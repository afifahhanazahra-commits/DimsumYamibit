<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan & Penjualan - Dimsum Yamibit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; background: white; }
            .print-page { box-shadow: none !important; border: none !important; max-width: 100% !important; margin: 0 !important; }
            @page { margin: 1.5cm; size: A4 portrait; }
        }
        body { font-family: 'Times New Roman', Times, serif; }
        .font-sans-custom { font-family: ui-sans-serif, system-ui, sans-serif; }
    </style>
</head>
<body class="bg-slate-100 min-h-screen py-8 px-4 flex flex-col items-center">

    <!-- Top Action Bar (Screen Only) -->
    <div class="no-print mb-6 max-w-4xl w-full flex items-center justify-between bg-slate-900 text-white p-4 rounded-2xl shadow-xl font-sans-custom">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-rose-600 flex items-center justify-center font-bold text-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <h4 class="font-bold text-sm">Cetak Laporan Keuangan PDF</h4>
                <p class="text-xs text-slate-400">Dimsum Yamibit • Laporan Resmi Penjualan & Keuangan Usaha</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="bg-rose-600 hover:bg-rose-700 text-white font-bold px-5 py-2 rounded-xl text-xs flex items-center gap-2 shadow transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Cetak / Simpan PDF</span>
            </button>
            <button onclick="window.close()" class="bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold px-4 py-2 rounded-xl text-xs">
                Tutup
            </button>
        </div>
    </div>

    <!-- Official Report Document (A4 Container) -->
    <div class="print-page bg-white max-w-4xl w-full p-10 sm:p-12 rounded-3xl shadow-2xl border border-slate-200 text-slate-900 space-y-6">
        
        <!-- Official Letterhead (Kop Surat) -->
        <div class="border-b-4 border-double border-black pb-4 text-center space-y-1">
            <h1 class="text-2xl font-black uppercase tracking-wider text-rose-800">DIMSUM YAMIBIT</h1>
            <h2 class="text-xs font-bold tracking-widest uppercase text-slate-700">KULINER DIMSUM & GYOZA PREMIUM HOMEMADE CIREBON</h2>
            <h3 class="text-base font-extrabold uppercase text-slate-900 mt-2">LAPORAN REKAPITULASI PENJUALAN & KEUANGAN TOKO</h3>
            <p class="text-xs text-slate-600">
                Alamat Outlet: Arumsari, Jl. Jembatan Merah No.02, Kecomberan, Kec. Talun, Kabupaten Cirebon • Kontak Operasional: 08990745953
            </p>
        </div>

        <!-- Report Meta Info Grid -->
        <div class="grid grid-cols-2 gap-4 text-xs font-sans-custom bg-slate-50 p-4 rounded-xl border border-slate-200">
            <div class="space-y-1">
                <div><span class="text-slate-500 font-medium">Unit Usaha:</span> <strong class="text-slate-900">Dimsum Yamibit Cirebon</strong></div>
                <div><span class="text-slate-500 font-medium">Dicetak Oleh:</span> <strong class="text-slate-900">Administrator / Kasir Toko</strong></div>
                <div><span class="text-slate-500 font-medium">Sistem Data:</span> <strong class="text-slate-900">Point of Sales (POS) & Manajemen Toko</strong></div>
            </div>
            <div class="space-y-1 text-right">
                <div><span class="text-slate-500 font-medium">Periode Transaksi:</span> <strong class="text-rose-700 font-extrabold">{{ $periodeLabel }}</strong></div>
                <div><span class="text-slate-500 font-medium">Tanggal Cetak:</span> <strong class="text-slate-900">{{ date('d F Y, H:i') }} WIB</strong></div>
                <div><span class="text-slate-500 font-medium">Status Data:</span> <strong class="text-emerald-700">Tervalidasi (Pembayaran Lunas)</strong></div>
            </div>
        </div>

        <!-- Section 1: Financial Summary Table -->
        <div class="space-y-2">
            <h4 class="font-bold text-sm uppercase tracking-wide border-b border-slate-300 pb-1 font-sans-custom">
                I. Ringkasan Eksekutif Finansial & Penjualan
            </h4>

            <table class="w-full text-xs font-sans-custom border border-slate-300 border-collapse">
                <tbody>
                    <tr class="border-b border-slate-200 bg-slate-50">
                        <td class="p-2.5 font-bold w-1/2">Total Transaksi Berhasil (Lunas)</td>
                        <td class="p-2.5 font-extrabold text-slate-900 text-right">{{ $totalTransaksi }} Transaksi</td>
                    </tr>
                    <tr class="border-b border-slate-200">
                        <td class="p-2.5 font-bold">Total Volume Produk Terjual</td>
                        <td class="p-2.5 font-extrabold text-amber-700 text-right">{{ $totalPorsi }} Porsi Dimsum / Gyoza</td>
                    </tr>
                    <tr class="border-b border-slate-200 bg-slate-50">
                        <td class="p-2.5 font-bold">Total Omzet Penjualan (Gross Revenue)</td>
                        <td class="p-2.5 font-extrabold text-rose-700 text-right text-sm">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="border-b border-slate-200">
                        <td class="p-2.5 font-bold">Estimasi Biaya Bahan Baku & HPP (~58%)</td>
                        <td class="p-2.5 font-bold text-slate-600 text-right">Rp {{ number_format($estimasiHPP, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="bg-emerald-50 text-emerald-950">
                        <td class="p-2.5 font-extrabold text-sm">Estimasi Laba Bersih (Net Profit ~42%)</td>
                        <td class="p-2.5 font-extrabold text-emerald-700 text-right text-base">Rp {{ number_format($estimasiLaba, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Section 2: Menu Sales Breakdown -->
        <div class="space-y-2 pt-2">
            <h4 class="font-bold text-sm uppercase tracking-wide border-b border-slate-300 pb-1 font-sans-custom">
                II. Rekapitulasi Penjualan Berdasarkan Varian Menu
            </h4>

            <table class="w-full text-xs font-sans-custom border border-slate-300 border-collapse text-left">
                <thead class="bg-slate-100 font-bold border-b border-slate-300">
                    <tr>
                        <th class="p-2 border-r border-slate-300 w-8 text-center">No</th>
                        <th class="p-2 border-r border-slate-300">Nama Varian Menu</th>
                        <th class="p-2 border-r border-slate-300">Harga Satuan</th>
                        <th class="p-2 border-r border-slate-300 text-center">Porsi Terjual</th>
                        <th class="p-2 border-r border-slate-300 text-right">Total Pendapatan</th>
                        <th class="p-2 text-right">Kontribusi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($menuBreakdown as $i => $item)
                        @php
                            $perc = $totalOmzet > 0 ? ($item->total_pendapatan / $totalOmzet) * 100 : 0;
                        @endphp
                        <tr>
                            <td class="p-2 border-r border-slate-300 text-center font-bold">{{ $i + 1 }}</td>
                            <td class="p-2 border-r border-slate-300 font-bold">{{ $item->menu ? $item->menu->nama_menu : 'Menu' }}</td>
                            <td class="p-2 border-r border-slate-300">{{ $item->menu ? $item->menu->formatted_harga : '-' }}</td>
                            <td class="p-2 border-r border-slate-300 text-center font-bold text-amber-800">{{ $item->total_porsi }} porsi</td>
                            <td class="p-2 border-r border-slate-300 text-right font-bold">Rp {{ number_format($item->total_pendapatan, 0, ',', '.') }}</td>
                            <td class="p-2 text-right font-bold text-rose-700">{{ number_format($perc, 1) }}%</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-4 text-center text-slate-400 italic">Belum ada data transaksi menu pada periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-slate-100 font-bold border-t-2 border-slate-300">
                    <tr>
                        <td colspan="3" class="p-2 text-right">TOTAL KESELURUHAN:</td>
                        <td class="p-2 text-center text-amber-800">{{ $totalPorsi }} porsi</td>
                        <td class="p-2 text-right text-rose-700 text-sm">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</td>
                        <td class="p-2 text-right">100%</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Section 3: Detailed Transaction Log Table -->
        <div class="space-y-2 pt-2">
            <h4 class="font-bold text-sm uppercase tracking-wide border-b border-slate-300 pb-1 font-sans-custom">
                III. Daftar Rincian Transaksi Pelanggan
            </h4>

            <table class="w-full text-[11px] font-sans-custom border border-slate-300 border-collapse text-left">
                <thead class="bg-slate-100 font-bold border-b border-slate-300">
                    <tr>
                        <th class="p-1.5 border-r border-slate-300 w-8 text-center">No</th>
                        <th class="p-1.5 border-r border-slate-300">Kode Transaksi</th>
                        <th class="p-1.5 border-r border-slate-300">Waktu</th>
                        <th class="p-1.5 border-r border-slate-300">Pelanggan</th>
                        <th class="p-1.5 border-r border-slate-300">Metode</th>
                        <th class="p-1.5 border-r border-slate-300">Item Pesanan</th>
                        <th class="p-1.5 text-right">Total (Rp)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($orders as $i => $ord)
                        <tr>
                            <td class="p-1.5 border-r border-slate-300 text-center">{{ $i + 1 }}</td>
                            <td class="p-1.5 border-r border-slate-300 font-bold">#{{ $ord->kode_pesanan }}</td>
                            <td class="p-1.5 border-r border-slate-300 text-[10px]">{{ $ord->tanggal_pesanan ? $ord->tanggal_pesanan->format('d/m/y H:i') : '-' }}</td>
                            <td class="p-1.5 border-r border-slate-300 font-medium">{{ $ord->pelanggan ? $ord->pelanggan->nama : '-' }}</td>
                            <td class="p-1.5 border-r border-slate-300 uppercase font-bold text-[10px]">{{ $ord->metode_pengiriman }}</td>
                            <td class="p-1.5 border-r border-slate-300 text-[10px]">
                                @foreach($ord->detailPesanan as $d)
                                    <span>{{ $d->jumlah }}x {{ $d->menu ? $d->menu->nama_menu : 'Item' }}{{ $d->topping ? '(+' . $d->topping->nama_topping . ')' : '' }}@if(!$loop->last), @endif</span>
                                @endforeach
                            </td>
                            <td class="p-1.5 text-right font-bold">{{ number_format($ord->total_harga, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-4 text-center text-slate-400 italic">Tidak ada catatan transaksi pada periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Section 4: Signature / Lembar Pengesahan Resmi Usaha -->
        <div class="pt-8 text-xs font-sans-custom space-y-12">
            <div class="text-right">
                <span>Cirebon, {{ date('d F Y') }}</span>
            </div>

            <div class="grid grid-cols-2 gap-12 text-center max-w-2xl mx-auto">
                
                <!-- Signature 1: Kasir / Staf Operasional -->
                <div class="space-y-16">
                    <div>
                        <span class="font-bold block">Dibuat Oleh,</span>
                        <span class="text-slate-600">Pengelola Kasir & Operasional</span>
                    </div>
                    <div>
                        <span class="font-bold underline text-sm block">Kasir Dimsum Yamibit</span>
                        <span class="text-[11px] text-slate-500">Operasional Toko</span>
                    </div>
                </div>

                <!-- Signature 2: Pemilik Bisnis -->
                <div class="space-y-16">
                    <div>
                        <span class="font-bold block">Mengetahui & Menyetujui,</span>
                        <span class="text-slate-600">Pemilik Usaha</span>
                    </div>
                    <div>
                        <span class="font-bold underline text-sm block">Owner Dimsum Yamibit</span>
                        <span class="text-[11px] text-slate-500">Pimpinan Usaha</span>
                    </div>
                </div>

            </div>
        </div>

    </div>

</body>
</html>
