<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Dapur #{{ $pesanan->kode_pesanan }} - Dimsum Yamibit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white; padding: 0; }
            .slip { box-shadow: none !important; border: 1px solid #000 !important; }
        }
        body { font-family: monospace; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen py-8 px-4 flex flex-col items-center justify-center">

    <div class="no-print mb-4 flex gap-3">
        <button onclick="window.print()" class="bg-slate-900 text-white font-bold px-4 py-2 rounded-lg text-xs flex items-center gap-2">
            <span>Cetak Nota Dapur</span>
        </button>
        <button onclick="window.close()" class="bg-gray-200 text-gray-700 font-bold px-4 py-2 rounded-lg text-xs">
            Tutup
        </button>
    </div>

    <div class="slip bg-white w-full max-w-xs p-5 rounded-xl border border-gray-300 text-xs space-y-3 shadow-md">
        <div class="text-center border-b-2 border-black pb-2 space-y-1">
            <img src="{{ asset('images/logo-circle.png') }}" alt="Dimsum Yamibit" class="w-10 h-10 mx-auto rounded-full object-cover">
            <h2 class="font-extrabold text-sm uppercase">KITCHEN SLIP / NOTA DAPUR</h2>
            <h3 class="font-bold">DIMSUM YAMIBIT</h3>
        </div>

        <div class="space-y-1 text-[11px] border-b border-gray-300 pb-2">
            <div class="flex justify-between font-bold text-sm">
                <span>ORDER:</span>
                <span>#{{ $pesanan->kode_pesanan }}</span>
            </div>
            <div class="flex justify-between">
                <span>WAKTU:</span>
                <span>{{ $pesanan->tanggal_pesanan ? $pesanan->tanggal_pesanan->format('d/m/Y H:i') : date('d/m/Y H:i') }}</span>
            </div>
            <div class="flex justify-between">
                <span>CUSTOMER:</span>
                <span class="font-bold">{{ $pesanan->pelanggan ? $pesanan->pelanggan->nama : '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span>METODE:</span>
                <span class="font-extrabold uppercase bg-black text-white px-1">{{ $pesanan->metode_pengiriman === 'pickup' ? 'PICKUP' : 'OJOL MANDIRI' }}</span>
            </div>
        </div>

        <div class="space-y-2 border-b-2 border-black pb-3">
            <span class="block font-bold text-[11px] text-gray-500">DAFTAR PESANAN KUKUS/GORENG:</span>
            @foreach($pesanan->detailPesanan as $detail)
                <div class="border-b border-dashed border-gray-200 pb-1">
                    <div class="flex justify-between font-extrabold text-sm">
                        <span>{{ $detail->jumlah }}x {{ $detail->menu ? $detail->menu->nama_menu : 'Item' }}</span>
                    </div>
                    <div class="text-[11px] font-bold text-gray-700 pl-4">
                        &bull; {{ $detail->topping ? 'Topping: ' . $detail->topping->nama_topping : 'Original (Tanpa Topping)' }}
                    </div>
                </div>
            @endforeach
        </div>

        @if($pesanan->metode_pengiriman === 'ojol' && $pesanan->pelanggan && $pesanan->pelanggan->alamat)
            <div class="text-[10px] border-b border-gray-300 pb-2">
                <span class="font-bold">CATATAN OJOL:</span>
                <p>{{ $pesanan->pelanggan->alamat }}</p>
            </div>
        @endif

        <div class="text-center text-[10px] text-gray-600 pt-1">
            <span>Dimsum Yamibit - Siapkan Pesanan Segar & Higienis</span>
        </div>
    </div>

</body>
</html>
