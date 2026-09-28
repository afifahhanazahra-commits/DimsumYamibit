@extends('layouts.admin')

@section('title', 'Dashboard Pengelola')
@section('header_title', 'Ringkasan & Analitik Bisnis')

@section('content')
<div class="space-y-8">
    
    <!-- Top Stat Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Card 1: Omzet Hari Ini -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
            <div class="space-y-1">
                <span class="text-xs font-extrabold uppercase tracking-wider text-slate-400">Omzet Hari Ini</span>
                <h3 class="text-2xl font-extrabold font-heading text-slate-900">
                    Rp {{ number_format($omzetHariIni, 0, ',', '.') }}
                </h3>
                <span class="text-[11px] text-emerald-600 font-bold flex items-center gap-1">
                    <i class="fa-solid fa-arrow-trend-up"></i> Penjualan tervalidasi
                </span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl shadow-inner">
                <i class="fa-solid fa-rupiah-sign"></i>
            </div>
        </div>

        <!-- Card 2: Omzet Bulan Ini -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex items-center justify-between hover:shadow-md transition-shadow">
            <div class="space-y-1">
                <span class="text-xs font-extrabold uppercase tracking-wider text-slate-400">Omzet Bulan Ini</span>
                <h3 class="text-2xl font-extrabold font-heading text-slate-900">
                    Rp {{ number_format($omzetBulanIni, 0, ',', '.') }}
                </h3>
                <span class="text-[11px] text-rose-600 font-bold">
                    {{ date('F Y') }}
                </span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shadow-inner">
                <i class="fa-solid fa-wallet"></i>
            </div>
        </div>

        <!-- Card 3: Pesanan Menunggu Verifikasi -->
        <a href="{{ route('admin.pesanan.index', ['status' => 'menunggu']) }}" class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex items-center justify-between hover:border-amber-400 hover:shadow-md transition-all group">
            <div class="space-y-1">
                <span class="text-xs font-extrabold uppercase tracking-wider text-slate-400">Menunggu Verifikasi</span>
                <h3 class="text-2xl font-extrabold font-heading text-amber-600 group-hover:scale-105 transition-transform">
                    {{ $pesananMenunggu }} Pesanan
                </h3>
                <span class="text-[11px] text-slate-500 font-medium">
                    Butuh cek bukti QRIS
                </span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-xl shadow-inner group-hover:bg-amber-500 group-hover:text-white transition-colors">
                <i class="fa-solid fa-bell"></i>
            </div>
        </a>

        <!-- Card 4: Peringatan Stok Menipis -->
        <a href="{{ route('admin.stok.index') }}" class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex items-center justify-between hover:border-rose-400 hover:shadow-md transition-all group">
            <div class="space-y-1">
                <span class="text-xs font-extrabold uppercase tracking-wider text-slate-400">Stok Menipis</span>
                <h3 class="text-2xl font-extrabold font-heading text-rose-600 group-hover:scale-105 transition-transform">
                    {{ $stokMenipisCount }} Menu
                </h3>
                <span class="text-[11px] text-slate-500 font-medium">
                    Persediaan &le; 10 porsi
                </span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center text-xl shadow-inner group-hover:bg-rose-600 group-hover:text-white transition-colors">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
        </a>

    </div>

    <!-- Charts & Analytics Row -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left: 7 Days Sales Trend Chart -->
        <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-lg font-bold font-heading text-slate-900">Grafik Penjualan 7 Hari Terakhir</h3>
                    <p class="text-xs text-slate-400">Tren pendapatan harian dari pesanan yang tervalidasi.</p>
                </div>
                <span class="bg-rose-50 text-rose-600 text-xs font-bold px-3 py-1 rounded-full">
                    Real-Time Data
                </span>
            </div>

            <div class="h-64 relative">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Right: Best Seller Dimsum -->
        <div class="lg:col-span-5 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-4 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <h3 class="text-lg font-bold font-heading text-slate-900">Varian Terlaris (Best Seller)</h3>
                    <span class="text-xs font-bold text-amber-600">Top 5</span>
                </div>

                <div class="mt-4 space-y-3">
                    @forelse($bestSellers as $idx => $best)
                        <div class="flex items-center justify-between text-xs p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                            <div class="flex items-center gap-3">
                                <span class="w-6 h-6 rounded-lg bg-rose-100 text-rose-700 font-extrabold flex items-center justify-center text-xs">
                                    {{ $idx + 1 }}
                                </span>
                                <div>
                                    <h4 class="font-bold text-slate-900">{{ $best->menu ? $best->menu->nama_menu : 'Menu' }}</h4>
                                    <p class="text-[11px] text-slate-500">{{ $best->total_terjual }} porsi terjual</p>
                                </div>
                            </div>
                            <span class="font-bold text-rose-600">
                                Rp {{ number_format($best->total_omzet, 0, ',', '.') }}
                            </span>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 py-6 text-center italic">Belum ada data transaksi yang tervalidasi.</p>
                    @endforelse
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 text-center">
                <a href="{{ route('admin.laporan.index') }}" class="text-xs font-bold text-rose-600 hover:text-rose-700 inline-flex items-center gap-1">
                    Lihat Laporan Keuangan Lengkap &rarr;
                </a>
            </div>
        </div>

    </div>

    <!-- Recent Orders Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden space-y-4 p-6 sm:p-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
            <div>
                <h3 class="text-lg font-bold font-heading text-slate-900">Pesanan Masuk Terbaru</h3>
                <p class="text-xs text-slate-400">Daftar transaksi harian yang perlu diproses dapur.</p>
            </div>
            <a href="{{ route('admin.pesanan.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition-colors">
                Kelola Semua Pesanan
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-100 text-slate-800 uppercase tracking-wider text-[11px] font-black border-y border-slate-200">
                    <tr>
                        <th class="px-4 py-3 rounded-l-xl">Kode Pesanan</th>
                        <th class="px-4 py-3">Pelanggan</th>
                        <th class="px-4 py-3">Metode</th>
                        <th class="px-4 py-3">Total Tagihan</th>
                        <th class="px-4 py-3">Status Bayar</th>
                        <th class="px-4 py-3">Status Dapur</th>
                        <th class="px-4 py-3 text-right rounded-r-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentOrders as $order)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-4 py-3.5 font-bold text-slate-900">
                                #{{ $order->kode_pesanan }}
                                <span class="block text-[10px] font-medium text-slate-500">{{ $order->tanggal_pesanan ? $order->tanggal_pesanan->format('d/m H:i') : '-' }}</span>
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="font-bold text-slate-900 block">{{ $order->pelanggan ? $order->pelanggan->nama : '-' }}</span>
                                <span class="text-[11px] text-slate-500">{{ $order->pelanggan ? $order->pelanggan->no_hp : '-' }}</span>
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="uppercase font-bold text-[10px] px-2 py-0.5 rounded {{ $order->metode_pengiriman === 'pickup' ? 'text-blue-700 bg-blue-50 border border-blue-200' : 'text-purple-700 bg-purple-50 border border-purple-200' }}">
                                    {{ $order->metode_pengiriman }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 font-black text-rose-600">
                                {{ $order->formatted_total }}
                            </td>
                            <td class="px-4 py-3.5">
                                @php $pBadge = $order->status_pembayaran_badge; @endphp
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold border {{ $pBadge['class'] }}">
                                    {{ $pBadge['label'] }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                @php $oBadge = $order->status_pesanan_badge; @endphp
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold border {{ $oBadge['class'] }}">
                                    {{ $oBadge['label'] }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-right">
                                <a href="{{ route('admin.pesanan.show', $order->id_pesanan) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold rounded-lg text-xs transition-colors">
                                    <i class="fa-solid fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-slate-400 italic">
                                Belum ada data pesanan yang masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('salesChart').getContext('2d');
        const labels = {!! json_encode($chartLabels) !!};
        const data = {!! json_encode($chartData) !!};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Omzet Penjualan (Rp)',
                    data: data,
                    borderColor: '#e11d48',
                    backgroundColor: 'rgba(225, 29, 72, 0.1)',
                    fill: true,
                    tension: 0.35,
                    borderWidth: 3,
                    pointBackgroundColor: '#e11d48',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ' Omzet: Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value / 1000) + 'k';
                            }
                        },
                        grid: {
                            color: '#f1f5f9'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
