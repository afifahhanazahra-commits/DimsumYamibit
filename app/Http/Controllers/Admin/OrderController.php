<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');

        $query = Pesanan::with(['pelanggan', 'detailPesanan.menu', 'detailPesanan.topping'])
            ->orderBy('id_pesanan', 'desc');

        if ($status === 'menunggu') {
            $query->where('status_pembayaran', 'menunggu');
        } elseif ($status === 'diproses') {
            $query->where('status_pesanan', 'diproses');
        } elseif ($status === 'siap_diambil') {
            $query->where('status_pesanan', 'siap_diambil');
        } elseif ($status === 'selesai') {
            $query->where('status_pesanan', 'selesai');
        } elseif ($status === 'ditolak') {
            $query->where('status_pembayaran', 'ditolak');
        }

        $pesanans = $query->paginate(10)->withQueryString();

        // Counts for tab badges
        $countAll = Pesanan::count();
        $countMenunggu = Pesanan::where('status_pembayaran', 'menunggu')->count();
        $countDiproses = Pesanan::where('status_pesanan', 'diproses')->count();
        $countSiap = Pesanan::where('status_pesanan', 'siap_diambil')->count();
        $countSelesai = Pesanan::where('status_pesanan', 'selesai')->count();
        $countDitolak = Pesanan::where('status_pembayaran', 'ditolak')->count();

        return view('admin.pesanan.index', compact(
            'pesanans',
            'status',
            'countAll',
            'countMenunggu',
            'countDiproses',
            'countSiap',
            'countSelesai',
            'countDitolak'
        ));
    }

    public function show($id)
    {
        $pesanan = Pesanan::with(['pelanggan', 'detailPesanan.menu', 'detailPesanan.topping'])
            ->findOrFail($id);

        return view('admin.pesanan.show', compact('pesanan'));
    }

    public function verifyPayment(Request $request, $id)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:valid,ditolak',
            'alasan_penolakan' => 'nullable|string',
        ]);

        $pesanan = Pesanan::with('detailPesanan.menu')->findOrFail($id);

        DB::beginTransaction();
        try {
            if ($request->status_pembayaran === 'valid') {
                // Jangan potong stok dua kali jika sebelumnya sudah valid
                $previouslyValid = ($pesanan->status_pembayaran === 'valid');

                $pesanan->status_pembayaran = 'valid';
                if ($pesanan->status_pesanan === 'menunggu_bayar') {
                    $pesanan->status_pesanan = 'diproses'; // Mulai dikukus
                }
                $pesanan->save();

                if (!$previouslyValid) {
                    // POTONG STOK OTOMATIS SECARA REAL-TIME
                    foreach ($pesanan->detailPesanan as $detail) {
                        $stok = Stok::where('id_menu', $detail->id_menu)->first();
                        if ($stok) {
                            $newStock = max(0, $stok->jumlah_stok - $detail->jumlah);
                            $stok->update([
                                'jumlah_stok' => $newStock,
                                'update_terakhir' => now(),
                            ]);

                            // Jika stok habis, tandai status menu
                            if ($newStock <= 0) {
                                Menu::where('id_menu', $detail->id_menu)->update(['status' => 'habis']);
                            }
                        }
                    }
                }

                $msg = "Pembayaran untuk pesanan #{$pesanan->kode_pesanan} dinyatakan VALID! Stok otomatis dipotong & pesanan siap dikukus.";
            } else {
                $pesanan->status_pembayaran = 'ditolak';
                $pesanan->status_pesanan = 'menunggu_bayar';
                $pesanan->save();

                $msg = "Pembayaran untuk pesanan #{$pesanan->kode_pesanan} DITOLAK. Pelanggan dapat mengunggah ulang bukti transfer yang benar.";
            }

            DB::commit();
            return back()->with('success', $msg);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memverifikasi pembayaran: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_pesanan' => 'required|in:menunggu_bayar,diproses,siap_diambil,selesai',
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update([
            'status_pesanan' => $request->status_pesanan,
        ]);

        $statusText = match ($request->status_pesanan) {
            'diproses' => 'Sedang Dikukus / Diproses di Dapur',
            'siap_diambil' => 'Siap Diambil / Siap Panggil Kurir',
            'selesai' => 'Selesai & Diserahkan',
            default => 'Menunggu Pembayaran',
        };

        return back()->with('success', "Status pesanan #{$pesanan->kode_pesanan} berhasil diperbarui menjadi '{$statusText}'.");
    }

    public function printStruk($id)
    {
        $pesanan = Pesanan::with(['pelanggan', 'detailPesanan.menu', 'detailPesanan.topping'])
            ->findOrFail($id);

        return view('admin.pesanan.struk', compact('pesanan'));
    }
}
