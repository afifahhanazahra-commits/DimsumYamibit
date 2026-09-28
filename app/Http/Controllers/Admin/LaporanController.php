<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->getReportData($request);

        return view('admin.laporan.index', $data);
    }

    public function printPdf(Request $request)
    {
        $data = $this->getReportData($request);

        return view('admin.laporan.print', $data);
    }

    public function exportCsv(Request $request)
    {
        $data = $this->getReportData($request);
        $orders = $data['orders'];

        $filename = 'laporan_penjualan_yamibit_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($orders, $data) {
            $file = fopen('php://output', 'w');
            // Write UTF-8 BOM for Excel
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header Info
            fputcsv($file, ['REKAPITULASI PENJUALAN & KEUANGAN DIMSUM YAMIBIT']);
            fputcsv($file, ['Periode:', $data['periodeLabel']]);
            fputcsv($file, ['Tanggal Cetak:', date('d-m-Y H:i:s')]);
            fputcsv($file, []);

            // Summary Info
            fputcsv($file, ['RINGKASAN FINANSIAL']);
            fputcsv($file, ['Total Transaksi Berhasil', $data['totalTransaksi']]);
            fputcsv($file, ['Total Porsi Terjual', $data['totalPorsi'] . ' porsi']);
            fputcsv($file, ['Total Omzet Penjualan (Kotor)', 'Rp ' . number_format($data['totalOmzet'], 0, ',', '.')]);
            fputcsv($file, ['Estimasi Laba Bersih (~40%)', 'Rp ' . number_format($data['estimasiLaba'], 0, ',', '.')]);
            fputcsv($file, []);

            // Detail Table
            fputcsv($file, ['DAFTAR TRANSAKSI']);
            fputcsv($file, ['No', 'Kode Pesanan', 'Tanggal', 'Nama Pelanggan', 'No HP', 'Metode', 'Item Pesanan', 'Total Tagihan', 'Status Pembayaran']);

            foreach ($orders as $i => $order) {
                $items = [];
                foreach ($order->detailPesanan as $d) {
                    $mName = $d->menu ? $d->menu->nama_menu : 'Item';
                    $tName = $d->topping ? " (+{$d->topping->nama_topping})" : '';
                    $items[] = "{$d->jumlah}x {$mName}{$tName}";
                }

                fputcsv($file, [
                    $i + 1,
                    $order->kode_pesanan,
                    $order->tanggal_pesanan ? $order->tanggal_pesanan->format('d/m/Y H:i') : '-',
                    $order->pelanggan ? $order->pelanggan->nama : '-',
                    $order->pelanggan ? "'" . $order->pelanggan->no_hp : '-',
                    $order->metode_pengiriman === 'pickup' ? 'Pickup' : 'Ojol Mandiri',
                    implode('; ', $items),
                    $order->total_harga,
                    ucfirst($order->status_pembayaran),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function getReportData(Request $request): array
    {
        $range = $request->query('range', 'this_month');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = Pesanan::with(['pelanggan', 'detailPesanan.menu', 'detailPesanan.topping'])
            ->where('status_pembayaran', 'valid')
            ->orderBy('tanggal_pesanan', 'asc');

        $today = Carbon::today();
        $periodeLabel = '';

        if ($range === 'today') {
            $query->whereDate('tanggal_pesanan', $today);
            $periodeLabel = 'Hari Ini (' . $today->translatedFormat('d F Y') . ')';
        } elseif ($range === '7days') {
            $from = Carbon::today()->subDays(6);
            $query->whereBetween('tanggal_pesanan', [$from->startOfDay(), Carbon::today()->endOfDay()]);
            $periodeLabel = '7 Hari Terakhir (' . $from->translatedFormat('d M') . ' - ' . $today->translatedFormat('d M Y') . ')';
        } elseif ($range === 'this_month') {
            $from = Carbon::now()->startOfMonth();
            $query->where('tanggal_pesanan', '>=', $from);
            $periodeLabel = 'Bulan Ini (' . Carbon::now()->translatedFormat('F Y') . ')';
        } elseif ($range === 'custom' && $startDate && $endDate) {
            $from = Carbon::parse($startDate)->startOfDay();
            $to = Carbon::parse($endDate)->endOfDay();
            $query->whereBetween('tanggal_pesanan', [$from, $to]);
            $periodeLabel = $from->translatedFormat('d M Y') . ' s/d ' . $to->translatedFormat('d M Y');
        } else {
            $range = 'all';
            $periodeLabel = 'Semua Periode Transaksi';
        }

        $orders = $query->get();

        // 1. Calculations
        $totalTransaksi = $orders->count();
        $totalOmzet = $orders->sum('total_harga');
        // Estimasi laba bersih rata-rata industri kuliner dimsum UMKM ~40-45%
        $estimasiLaba = (int) ($totalOmzet * 0.42);
        $estimasiHPP = $totalOmzet - $estimasiLaba;

        // 2. Breakdown per Menu
        $orderIds = $orders->pluck('id_pesanan');
        $menuBreakdown = DetailPesanan::select(
            'id_menu',
            DB::raw('SUM(jumlah) as total_porsi'),
            DB::raw('SUM(subtotal) as total_pendapatan')
        )
            ->whereIn('id_pesanan', $orderIds)
            ->with('menu')
            ->groupBy('id_menu')
            ->orderByDesc('total_porsi')
            ->get();

        $totalPorsi = $menuBreakdown->sum('total_porsi');

        // 3. Breakdown per Metode Pengiriman
        $pickupCount = $orders->where('metode_pengiriman', 'pickup')->count();
        $ojolCount = $orders->where('metode_pengiriman', 'ojol')->count();

        return [
            'orders' => $orders,
            'totalTransaksi' => $totalTransaksi,
            'totalOmzet' => $totalOmzet,
            'estimasiLaba' => $estimasiLaba,
            'estimasiHPP' => $estimasiHPP,
            'totalPorsi' => $totalPorsi,
            'menuBreakdown' => $menuBreakdown,
            'pickupCount' => $pickupCount,
            'ojolCount' => $ojolCount,
            'range' => $range,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'periodeLabel' => $periodeLabel,
        ];
    }
}
