<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
use App\Models\Menu;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Models\Topping;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function checkout()
    {
        $menus = Menu::with('stok')->where('status', 'tersedia')->get();
        $toppings = Topping::all();
        $storeStatus = \App\Services\StoreSchedule::getStatus();

        return view('frontend.checkout', compact('menus', 'toppings', 'storeStatus'));
    }

    public function store(Request $request)
    {
        $storeStatus = \App\Services\StoreSchedule::getStatus();
        if (!$storeStatus['is_open']) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Mohon maaf, pemesanan saat ini dinonaktifkan karena toko sedang tutup. ' . $storeStatus['message']);
        }

        $request->validate([
            'nama' => 'required|string|max:100',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'metode_pengiriman' => 'required|in:pickup,ojol',
            'items' => 'required|array|min:1',
            'items.*.id_menu' => 'required|exists:menu,id_menu',
            'items.*.id_topping' => 'nullable|exists:topping,id_topping',
            'items.*.jumlah' => 'required|integer|min:1',
            'bukti_qris' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'nama.required' => 'Nama lengkap pemesan wajib diisi.',
            'no_hp.required' => 'Nomor WhatsApp aktif wajib diisi.',
            'metode_pengiriman.required' => 'Pilih salah satu metode pemenuhan pesanan.',
            'items.required' => 'Keranjang pesanan tidak boleh kosong.',
            'bukti_qris.required' => 'Unggah foto bukti pembayaran QRIS / transfer.',
            'bukti_qris.image' => 'File bukti pembayaran harus berupa gambar (JPG, PNG, WebP).',
            'bukti_qris.max' => 'Ukuran file bukti pembayaran maksimal 5MB.',
        ]);

        DB::beginTransaction();
        try {
            //  simpan / perbarui data pelanggan
            $pelanggan = Pelanggan::firstOrCreate(
                ['no_hp' => $request->no_hp],
                [
                    'nama' => $request->nama,
                    'alamat' => $request->alamat,
                ]
            );

            // update nama / alamat klo ada perubahan
            $pelanggan->update([
                'nama' => $request->nama,
                'alamat' => $request->alamat ?: $pelanggan->alamat,
            ]);

            // bikin kode pesananny
            $today = Carbon::now();
            $datePrefix = $today->format('Ymd');
            $countToday = Pesanan::whereDate('tanggal_pesanan', $today->toDateString())->count() + 1;
            $kodePesanan = 'YAMI-' . $datePrefix . '-' . str_pad($countToday, 4, '0', STR_PAD_LEFT);

            // up bukti qris
            $buktiPath = null;
            if ($request->hasFile('bukti_qris')) {
                $file = $request->file('bukti_qris');
                $filename = 'qris_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/bukti_qris'), $filename);
                $buktiPath = 'uploads/bukti_qris/' . $filename;
            }

            // buat pesanan (header)
            $pesanan = Pesanan::create([
                'kode_pesanan' => $kodePesanan,
                'id_pelanggan' => $pelanggan->id_pelanggan,
                'tanggal_pesanan' => $today,
                'metode_pengiriman' => $request->metode_pengiriman,
                'bukti_qris' => $buktiPath,
                'status_pembayaran' => 'menunggu',
                'status_pesanan' => 'menunggu_bayar',
                'total_harga' => 0,
                'link_wa' => '',
            ]);

            // nampilin detail pesanannya sama jumah hrganya
            $totalHarga = 0;
            foreach ($request->items as $item) {
                $menu = Menu::findOrFail($item['id_menu']);
                $topping = !empty($item['id_topping']) ? Topping::find($item['id_topping']) : null;

                $hargaSatuan = $menu->harga + ($topping ? $topping->harga_tambahan : 0);
                $qty = (int) $item['jumlah'];
                $subtotal = $hargaSatuan * $qty;

                DetailPesanan::create([
                    'id_pesanan' => $pesanan->id_pesanan,
                    'id_menu' => $menu->id_menu,
                    'id_topping' => $topping ? $topping->id_topping : null,
                    'jumlah' => $qty,
                    'subtotal' => $subtotal,
                ]);

                $totalHarga += $subtotal;
            }

            // update total &  Link wa
            $pesanan->total_harga = $totalHarga;
            $pesanan->link_wa = $pesanan->generateWaLink();
            $pesanan->save();

            DB::commit();

            return redirect()->route('order.status', $pesanan->kode_pesanan)
                ->with('success', 'Pesanan Anda berhasil dikirim! Silakan pantau status dan hubungi pengelola via WhatsApp.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }

    public function show($kode_pesanan)
    {
        $pesanan = Pesanan::with(['pelanggan', 'detailPesanan.menu', 'detailPesanan.topping'])
            ->where('kode_pesanan', $kode_pesanan)
            ->firstOrFail();

        return view('frontend.order-status', compact('pesanan'));
    }

    public function reuploadBukti(Request $request, $kode_pesanan)
    {
        $request->validate([
            'bukti_qris' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'bukti_qris.required' => 'Unggah foto bukti transfer yang valid.',
            'bukti_qris.image' => 'File bukti harus berupa gambar (JPG, PNG, WebP).',
            'bukti_qris.max' => 'Ukuran file maksimal 5MB.',
        ]);

        $pesanan = Pesanan::where('kode_pesanan', $kode_pesanan)->firstOrFail();

        if ($request->hasFile('bukti_qris')) {
            $file = $request->file('bukti_qris');
            $filename = 'qris_reupload_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/bukti_qris'), $filename);

            $pesanan->update([
                'bukti_qris' => 'uploads/bukti_qris/' . $filename,
                'status_pembayaran' => 'menunggu',
                'status_pesanan' => 'menunggu_bayar',
            ]);

            return back()->with('success', 'Bukti pembayaran berhasil diunggah ulang! Admin akan segera memeriksa kembali.');
        }

        return back()->with('error', 'Gagal mengunggah foto bukti pembayaran.');
    }

    public function printStruk($kode_pesanan)
    {
        $pesanan = Pesanan::with(['pelanggan', 'detailPesanan.menu', 'detailPesanan.topping'])
            ->where('kode_pesanan', $kode_pesanan)
            ->firstOrFail();

        return view('frontend.receipt-print', compact('pesanan'));
    }
}
