@extends('layouts.admin')

@section('title', 'Laporan Penjualan & Rekapitulasi Keuangan')
@section('header_title', 'Laporan Keuangan & Rekapitulasi Penjualan')

@section('content')
<div class="space-y-8">
    
    <!-- Filter Card & Export Buttons -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
            <div>
                <h3 class="font-bold font-heading text-slate-900 text-lg">Filter Periode Laporan</h3>
                <p class="text-xs text-slate-400">Pilih rentang tanggal untuk merekapitulasi arus kas dan volume penjualan.</p>
            </div>

            <!-- Export PDF Button Only -->
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <a href="{{ route('admin.laporan.print', ['range' => $range, 'start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="w-full sm:w-auto btn-gradient text-white px-5 py-2.5 rounded-xl text-xs font-bold shadow-md flex items-center justify-center gap-2">
                    <i class="fa-solid fa-file-pdf text-sm"></i>
                    <span>Cetak & Unduh Laporan PDF</span>
                </a>
            </div>
        </div>

        <!-- Filter Form -->
        <form action="{{ route('admin.laporan.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-4 items-end text-xs">
            <div class="sm:col-span-4">
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pilihan Rentang Waktu</label>
                <select name="range" id="filter-range" onchange="toggleCustomDateInputs()" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl font-bold text-slate-800 focus:ring-2 focus:ring-rose-500 outline-none">
                    <option value="today" {{ $range === 'today' ? 'selected' : '' }}>Hari Ini</option>
                    <option value="7days" {{ $range === '7days' ? 'selected' : '' }}>7 Hari Terakhir</option>
                    <option value="this_month" {{ $range === 'this_month' ? 'selected' : '' }}>Bulan Ini ({{ date('F Y') }})</option>
                    <option value="all" {{ $range === 'all' ? 'selected' : '' }}>Semua Waktu Transaksi</option>
                    <option value="custom" {{ $range === 'custom' ? 'selected' : '' }}>Rentang Tanggal Kustom</option>
                </select>
            </div>

            <div id="custom-start-col" class="{{ $range === 'custom' ? '' : 'hidden' }} sm:col-span-3">
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl font-bold text-slate-800 outline-none">
            </div>

            <div id="custom-end-col" class="{{ $range === 'custom' ? '' : 'hidden' }} sm:col-span-3">
                <label class="block font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Sampai</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl font-bold text-slate-800 outline-none">
            </div>

            <div class="sm:col-span-2">
                <button type="submit" class="w-full py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-bold transition-colors flex items-center justify-center gap-2">
                    <i class="fa-solid fa-filter"></i>
                    <span>Terapkan Filter</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Active Filter Indicator -->
    <div class="bg-rose-50 border border-rose-200 rounded-2xl p-4 flex items-center justify-between text-xs text-rose-900">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-calendar-check text-rose-600 text-base"></i>
            <span class="font-bold">Periode Laporan Aktif:</span>
            <span class="bg-white px-3 py-1 rounded-lg border border-rose-200 font-extrabold text-rose-700">{{ $periodeLabel }}</span>
        </div>
        <span class="text-[11px] text-rose-600 font-semibold hidden sm:inline">Hanya menghitung pesanan dengan status 'Pembayaran Valid'</span>
    </div>

    <!-- Summary Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-1">
            <span class="text-xs font-extrabold uppercase tracking-wider text-slate-400">Total Transaksi</span>
            <h3 class="text-3xl font-extrabold font-heading text-slate-900">{{ $totalTransaksi }}</h3>
            <span class="text-[11px] text-slate-500">Pesanan tervalidasi</span>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-1">
            <span class="text-xs font-extrabold uppercase tracking-wider text-slate-400">Porsi Terjual</span>
            <h3 class="text-3xl font-extrabold font-heading text-amber-600">{{ $totalPorsi }}</h3>
            <span class="text-[11px] text-slate-500">Porsi dimsum & gyoza</span>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-1">
            <span class="text-xs font-extrabold uppercase tracking-wider text-slate-400">Total Omzet (Kotor)</span>
            <h3 class="text-3xl font-extrabold font-heading text-rose-600">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</h3>
            <span class="text-[11px] text-slate-500">Arus kas masuk bruto</span>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-1">
            <span class="text-xs font-extrabold uppercase tracking-wider text-slate-400">Estimasi Laba Bersih</span>
            <h3 class="text-3xl font-extrabold font-heading text-emerald-600">Rp {{ number_format($estimasiLaba, 0, ',', '.') }}</h3>
            <span class="text-[11px] text-emerald-700 font-semibold">Margin laba bersih ~42%</span>
        </div>

    </div>

    <!-- Breakdown Table: Penjualan Per Varian Menu -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-6 sm:p-8 space-y-4">
        <div class="border-b border-slate-100 pb-3">
            <h3 class="font-bold font-heading text-slate-900 text-base">Rekapitulasi Volume Penjualan Per Varian Menu</h3>
            <p class="text-xs text-slate-400">Analisis produk yang paling berkontribusi terhadap pendapatan usaha Dimsum Yamibit.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-100 text-slate-800 uppercase tracking-wider text-[11px] font-black border-y border-slate-200">
                    <tr>
                        <th class="px-5 py-3.5 rounded-l-xl">No</th>
                        <th class="px-5 py-3.5">Varian Dimsum</th>
                        <th class="px-5 py-3.5">Harga Dasar</th>
                        <th class="px-5 py-3.5">Total Porsi Terjual</th>
                        <th class="px-5 py-3.5">Total Pendapatan</th>
                        <th class="px-5 py-3.5 text-right rounded-r-xl">Kontribusi Omzet</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($menuBreakdown as $idx => $mb)
                        @php
                            $percentage = $totalOmzet > 0 ? ($mb->total_pendapatan / $totalOmzet) * 100 : 0;
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-5 py-3.5 font-bold text-slate-500 w-12">{{ $idx + 1 }}</td>
                            <td class="px-5 py-3.5 font-extrabold text-slate-900 text-sm">
                                {{ $mb->menu ? $mb->menu->nama_menu : 'Menu' }}
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="font-bold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-lg border border-rose-100 inline-block text-xs">
                                    {{ $mb->menu ? $mb->menu->formatted_harga : '-' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="font-black text-amber-700 bg-amber-50 px-2.5 py-1 rounded-lg border border-amber-200 inline-block text-xs">
                                    {{ $mb->total_porsi }} porsi
                                </span>
                            </td>
                            <td class="px-5 py-3.5 font-black text-emerald-700 text-sm">
                                Rp {{ number_format($mb->total_pendapatan, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <span class="font-black text-xs text-rose-700 bg-rose-100/80 px-2.5 py-1 rounded-xl border border-rose-200 inline-block">{{ number_format($percentage, 1) }}%</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-slate-400 italic">
                                Belum ada data penjualan pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Detail Transactions Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-6 sm:p-8 space-y-4">
        <div class="border-b border-slate-100 pb-3">
            <h3 class="font-bold font-heading text-slate-900 text-base">Rincian Seluruh Transaksi Penjualan</h3>
            <p class="text-xs text-slate-400">Daftar nota transaksi tervalidasi yang masuk dalam periode laporan ini.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-100 text-slate-800 uppercase tracking-wider text-[11px] font-black border-y border-slate-200">
                    <tr>
                        <th class="px-4 py-3 rounded-l-xl">No</th>
                        <th class="px-4 py-3">Kode Order</th>
                        <th class="px-4 py-3">Waktu</th>
                        <th class="px-4 py-3">Nama Pelanggan</th>
                        <th class="px-4 py-3">Metode</th>
                        <th class="px-4 py-3">Rincian Item</th>
                        <th class="px-4 py-3 text-right rounded-r-xl">Nominal Lunas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $idx => $order)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-4 py-3 font-bold text-slate-500">{{ $idx + 1 }}</td>
                            <td class="px-4 py-3">
                                <span class="font-extrabold text-slate-900 bg-slate-100 px-2 py-0.5 rounded-lg border border-slate-200">#{{ $order->kode_pesanan }}</span>
                            </td>
                            <td class="px-4 py-3 text-slate-600 font-medium text-[11px]">{{ $order->tanggal_pesanan ? $order->tanggal_pesanan->format('d/m/Y H:i') : '-' }}</td>
                            <td class="px-4 py-3 font-extrabold text-slate-900">{{ $order->pelanggan ? $order->pelanggan->nama : '-' }}</td>
                            <td class="px-4 py-3 uppercase font-bold text-[10px] {{ $order->metode_pengiriman === 'pickup' ? 'text-blue-700 bg-blue-50 px-2 py-0.5 rounded border border-blue-200' : 'text-purple-700 bg-purple-50 px-2 py-0.5 rounded border border-purple-200' }}">
                                {{ $order->metode_pengiriman }}
                            </td>
                            <td class="px-4 py-3 max-w-xs">
                                <div class="space-y-0.5 text-[11px]">
                                    @foreach($order->detailPesanan as $d)
                                        <div>
                                            <span class="font-bold text-slate-900">{{ $d->jumlah }}x</span> <span class="text-slate-700">{{ $d->menu ? $d->menu->nama_menu : 'Item' }}</span>
                                            @if($d->topping)
                                                <span class="text-[10px] font-bold text-rose-600">(+{{ $d->topping->nama_topping }})</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-4 py-3 font-black text-emerald-700 text-right text-sm">
                                {{ $order->formatted_total }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-slate-400 italic">
                                Belum ada transaksi tervalidasi pada periode ini.
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
<script>
    function toggleCustomDateInputs() {
        const range = document.getElementById('filter-range').value;
        const startCol = document.getElementById('custom-start-col');
        const endCol = document.getElementById('custom-end-col');
        if (range === 'custom') {
            startCol.classList.remove('hidden');
            endCol.classList.remove('hidden');
        } else {
            startCol.classList.add('hidden');
            endCol.classList.add('hidden');
        }
    }
</script>
@endsection
