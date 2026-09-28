<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pesanan #{{ $pesanan->kode_pesanan }} - Dimsum Yamibit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { background: transparent; }
            .no-print { display: none !important; }
            .receipt-card { box-shadow: none !important; border: none !important; }
        }
        body { font-family: 'Courier New', Courier, monospace; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen py-8 px-4 flex flex-col items-center justify-center">

    <!-- Action Bar (Not printed) -->
    <div class="no-print mb-6 flex items-center gap-3">
        <button onclick="window.print()" class="bg-rose-600 hover:bg-rose-700 text-white font-bold px-5 py-2.5 rounded-xl shadow text-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            <span>Cetak Struk (Print)</span>
        </button>
        <button onclick="window.close()" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold px-4 py-2.5 rounded-xl text-sm">
            Tutup
        </button>
    </div>

    <!-- Receipt Thermal Container (80mm width standard) -->
    <div class="receipt-card bg-white w-full max-w-sm p-6 rounded-2xl shadow-xl border border-gray-200 text-xs text-gray-900 space-y-4">
        
        <!-- Header -->
        <div class="text-center space-y-1.5 border-b-2 border-dashed border-gray-300 pb-4">
            <img src="{{ asset('images/logo-circle.png') }}" alt="Dimsum Yamibit" class="w-12 h-12 mx-auto rounded-full object-cover">
            <h2 class="text-base font-extrabold uppercase tracking-wider">DIMSUM YAMIBIT</h2>
            <p class="text-[11px] text-gray-600 leading-tight">
                Arumsari, Jl. Jembatan Merah No.02, Kecomberan, Talun, Cirebon<br>
                WhatsApp: 08990745953
            </p>
        </div>

        <!-- Meta Info -->
        <div class="space-y-1 border-b border-dashed border-gray-200 pb-3 text-[11px]">
            <div class="flex justify-between">
                <span>No. Pesanan:</span>
                <span class="font-bold">#{{ $pesanan->kode_pesanan }}</span>
            </div>
            <div class="flex justify-between">
                <span>Tanggal:</span>
                <span>{{ $pesanan->tanggal_pesanan ? $pesanan->tanggal_pesanan->format('d/m/Y H:i') : date('d/m/Y H:i') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Pemesan:</span>
                <span class="font-bold">{{ $pesanan->pelanggan ? $pesanan->pelanggan->nama : '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span>No. HP:</span>
                <span>{{ $pesanan->pelanggan ? $pesanan->pelanggan->no_hp : '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span>Metode:</span>
                <span class="uppercase font-bold">{{ $pesanan->metode_pengiriman === 'pickup' ? 'Pickup (Toko)' : 'Ojol Mandiri' }}</span>
            </div>
        </div>

        <!-- Items Table -->
        <div class="space-y-2 border-b-2 border-dashed border-gray-300 pb-4">
            @foreach($pesanan->detailPesanan as $detail)
                <div>
                    <div class="flex justify-between font-bold">
                        <span>{{ $detail->menu ? $detail->menu->nama_menu : 'Menu' }}</span>
                        <span>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-500 text-[10px]">
                        <span>
                            {{ $detail->jumlah }} x @ Rp {{ number_format($detail->subtotal / $detail->jumlah, 0, ',', '.') }}
                            {{ $detail->topping ? '(+' . $detail->topping->nama_topping . ')' : '' }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Totals -->
        <div class="space-y-1.5 pt-1 text-xs">
            <div class="flex justify-between">
                <span>Subtotal Menu:</span>
                <span>{{ $pesanan->formatted_total }}</span>
            </div>
            <div class="flex justify-between">
                <span>Metode Bayar:</span>
                <span class="font-bold uppercase">QRIS Toko (Transfer)</span>
            </div>
            <div class="flex justify-between">
                <span>Status Bayar:</span>
                <span class="font-bold uppercase">{{ $pesanan->status_pembayaran === 'valid' ? 'LUNAS (Valid)' : 'Menunggu Verifikasi' }}</span>
            </div>
            <div class="flex justify-between text-sm font-extrabold border-t border-dashed border-gray-300 pt-2 text-rose-700">
                <span>TOTAL AKHIR:</span>
                <span>{{ $pesanan->formatted_total }}</span>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="text-center pt-4 border-t-2 border-dashed border-gray-300 text-[10px] text-gray-500 space-y-1">
            <p class="font-bold">Terima kasih atas pesanan Anda!</p>
            <p>Simpan struk digital ini untuk bukti penjemputan pesanan di outlet.</p>
        </div>

    </div>

</body>
</html>
