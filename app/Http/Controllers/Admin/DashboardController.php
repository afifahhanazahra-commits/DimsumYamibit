<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\Stok;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();

        // 1. Core Summary Metrics
        $omzetHariIni = Pesanan::where('status_pembayaran', 'valid')
            ->whereDate('tanggal_pesanan', $today)
            ->sum('total_harga');

        $omzetBulanIni = Pesanan::where('status_pembayaran', 'valid')
            ->where('tanggal_pesanan', '>=', $startOfMonth)
            ->sum('total_harga');

        $pesananMenunggu = Pesanan::where('status_pembayaran', 'menunggu')->count();
        $pesananAktif = Pesanan::whereIn('status_pesanan', ['diproses', 'siap_diambil'])->count();
        $pesananSelesai = Pesanan::where('status_pesanan', 'selesai')->count();

        $stokMenipisCount = Stok::where('jumlah_stok', '<=', 10)->count();

        // 2. Chart: 7 Days Sales Trend
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->translatedFormat('D, d M');
            $dailySum = Pesanan::where('status_pembayaran', 'valid')
                ->whereDate('tanggal_pesanan', $date)
                ->sum('total_harga');
            $chartData[] = $dailySum;
        }

        // 3. Best Seller Menus (by quantity sold in valid orders)
        $bestSellers = DetailPesanan::select('id_menu', DB::raw('SUM(jumlah) as total_terjual'), DB::raw('SUM(subtotal) as total_omzet'))
            ->whereHas('pesanan', function ($q) {
                $q->where('status_pembayaran', 'valid');
            })
            ->with('menu')
            ->groupBy('id_menu')
            ->orderByDesc('total_terjual')
            ->take(5)
            ->get();

        // 4. Low Stock Menus Alert List
        $lowStocks = Stok::with('menu')
            ->where('jumlah_stok', '<=', 10)
            ->orderBy('jumlah_stok', 'asc')
            ->get();

        // 5. Recent 6 Orders
        $recentOrders = Pesanan::with(['pelanggan', 'detailPesanan.menu'])
            ->orderBy('id_pesanan', 'desc')
            ->take(6)
            ->get();

        return view('admin.dashboard', compact(
            'omzetHariIni',
            'omzetBulanIni',
            'pesananMenunggu',
            'pesananAktif',
            'pesananSelesai',
            'stokMenipisCount',
            'chartLabels',
            'chartData',
            'bestSellers',
            'lowStocks',
            'recentOrders'
        ));
    }
}
