@extends('layouts.app')

@section('title', 'Status Pesanan #' . $pesanan->kode_pesanan . ' - Dimsum Yamibit')

@section('content')
<div class="py-12 bg-slate-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header & Code Badge -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-200/80 shadow-sm text-center sm:text-left sm:flex sm:items-center sm:justify-between gap-6">
            <div class="space-y-1">
                <div class="inline-flex items-center gap-2 text-xs font-bold text-rose-600 bg-rose-50 px-3 py-1 rounded-full border border-rose-200">
                    <i class="fa-solid fa-receipt"></i>
                    <span>Bukti Transaksi Pesanan</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-gray-900">
                    Pesanan #{{ $pesanan->kode_pesanan }}
                </h1>
                <p class="text-xs text-gray-500">
                    Waktu Pemesanan: {{ $pesanan->tanggal_pesanan ? $pesanan->tanggal_pesanan->translatedFormat('d F Y, H:i') : '-' }} WIB
                </p>
            </div>

            <div class="mt-4 sm:mt-0 flex flex-col sm:items-end gap-2">
                @php
                    $payBadge = $pesanan->status_pembayaran_badge;
                @endphp
                <span class="inline-flex items-center gap-1.5 text-xs font-extrabold px-3.5 py-1.5 rounded-xl border {{ $payBadge['class'] }}">
                    <i class="fa-solid {{ $pesanan->status_pembayaran === 'valid' ? 'fa-circle-check' : ($pesanan->status_pembayaran === 'ditolak' ? 'fa-circle-xmark' : 'fa-clock') }}"></i>
                    {{ $payBadge['label'] }}
                </span>
                
                <a href="{{ route('order.struk', $pesanan->kode_pesanan) }}" target="_blank" class="inline-flex items-center gap-2 text-xs font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 px-3.5 py-1.5 rounded-xl transition-colors">
                    <i class="fa-solid fa-print text-rose-600"></i>
                    <span>Cetak Struk Digital</span>
                </a>
            </div>
        </div>

        <!-- Alert: If Payment Rejected (Ditolak) -->
        @if($pesanan->status_pembayaran === 'ditolak')
            <div class="bg-rose-50 border-2 border-rose-500 rounded-3xl p-6 sm:p-8 shadow-sm space-y-4">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-rose-600 text-white flex items-center justify-center flex-shrink-0 text-xl">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-lg font-bold text-rose-950 font-heading">Bukti Pembayaran Tidak Valid / Ditolak</h3>
                        <p class="text-xs text-rose-800 leading-relaxed">
                            Admin tidak dapat memvalidasi bukti transfer/QRIS yang Anda kirimkan. Silakan periksa kembali nominal transfer atau mutasi rekening Anda, lalu unggah ulang foto bukti transfer yang benar di bawah ini:
                        </p>
                    </div>
                </div>

                <!-- Reupload Form -->
                <form action="{{ route('order.reupload', $pesanan->kode_pesanan) }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded-2xl border border-rose-200 space-y-3">
                    @csrf
                    <label class="block text-xs font-bold text-gray-700">Pilih Foto Bukti Transfer yang Baru:</label>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <input type="file" name="bukti_qris" accept="image/*" required class="text-xs file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100">
                        <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow transition-colors flex items-center justify-center gap-2">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <span>Unggah Ulang Bukti</span>
                        </button>
                    </div>
                </form>
            </div>
        @endif

        <!-- Order Progress Stepper -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-200/80 shadow-sm space-y-6">
            <h3 class="text-base font-bold font-heading text-gray-900 border-b border-gray-100 pb-3">
                Status Pemrosesan Pesanan
            </h3>

            @php
                $step = 1;
                if ($pesanan->status_pembayaran === 'valid') {
                    if ($pesanan->status_pesanan === 'diproses') $step = 2;
                    elseif ($pesanan->status_pesanan === 'siap_diambil') $step = 3;
                    elseif ($pesanan->status_pesanan === 'selesai') $step = 4;
                }
            @endphp

            <!-- Desktop & Mobile Stepper -->
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                
                <!-- Step 1 -->
                <div class="flex sm:flex-col items-center sm:text-center gap-3 p-3 rounded-2xl {{ $step >= 1 ? 'bg-rose-50/70 border border-rose-200' : 'bg-gray-50' }}">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm {{ $step >= 1 ? 'bg-rose-600 text-white' : 'bg-gray-200 text-gray-400' }}">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <div>
                        <p class="font-bold text-xs text-gray-900">1. Verifikasi Pembayaran</p>
                        <p class="text-[10px] text-gray-500">{{ $pesanan->status_pembayaran === 'valid' ? 'Tervalidasi' : 'Pengecekan bukti QRIS' }}</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="flex sm:flex-col items-center sm:text-center gap-3 p-3 rounded-2xl {{ $step >= 2 ? 'bg-rose-50/70 border border-rose-200' : 'bg-gray-50' }}">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm {{ $step >= 2 ? 'bg-rose-600 text-white' : 'bg-gray-200 text-gray-400' }}">
                        <i class="fa-solid fa-fire-burner"></i>
                    </div>
                    <div>
                        <p class="font-bold text-xs text-gray-900">2. Sedang Dikukus</p>
                        <p class="text-[10px] text-gray-500">Dapur menyiapkan pesanan</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="flex sm:flex-col items-center sm:text-center gap-3 p-3 rounded-2xl {{ $step >= 3 ? 'bg-rose-50/70 border border-rose-200' : 'bg-gray-50' }}">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm {{ $step >= 3 ? 'bg-rose-600 text-white' : 'bg-gray-200 text-gray-400' }}">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </div>
                    <div>
                        <p class="font-bold text-xs text-gray-900">3. Siap Diambil</p>
                        <p class="text-[10px] text-gray-500">{{ $pesanan->metode_pengiriman === 'pickup' ? 'Ambil di outlet' : 'Panggil kurir ojol' }}</p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="flex sm:flex-col items-center sm:text-center gap-3 p-3 rounded-2xl {{ $step >= 4 ? 'bg-emerald-50 border border-emerald-200' : 'bg-gray-50' }}">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm {{ $step >= 4 ? 'bg-emerald-600 text-white' : 'bg-gray-200 text-gray-400' }}">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <div>
                        <p class="font-bold text-xs text-gray-900">4. Selesai</p>
                        <p class="text-[10px] text-gray-500">Pesanan diserahkan</p>
                    </div>
                </div>

            </div>
        </div>

        <!-- Direct WhatsApp Coordination Action -->
        <div class="bg-gradient-to-r from-emerald-600 to-teal-700 rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="space-y-2 text-center sm:text-left">
                <div class="inline-flex items-center gap-2 bg-white/20 px-3 py-1 rounded-full text-xs font-bold text-white">
                    <i class="fa-brands fa-whatsapp text-sm"></i>
                    <span>Tautan Layanan Langsung Pengelola</span>
                </div>
                <h3 class="text-xl font-extrabold font-heading">Konfirmasi Pesanan via WhatsApp</h3>
                <p class="text-xs text-emerald-100 max-w-lg leading-relaxed">
                    Klik tombol di samping untuk langsung membuka percakapan WhatsApp dengan pengelola Dimsum Yamibit (08990745953). Rincian kode transaksi Anda otomatis tersusun rapi.
                </p>
            </div>

            <a href="{{ $pesanan->link_wa ?: $pesanan->generateWaLink() }}" target="_blank" class="bg-white hover:bg-emerald-50 text-emerald-800 font-extrabold px-6 py-3.5 rounded-2xl text-sm shadow-lg transition-transform hover:scale-105 flex items-center gap-2 flex-shrink-0">
                <i class="fa-brands fa-whatsapp text-xl text-emerald-600"></i>
                <span>Hubungi Pengelola Toko</span>
            </a>
        </div>

        <!-- Order Items & Customer Details Breakdown -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Items Card -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-200/80 shadow-sm space-y-4">
                <h3 class="text-base font-bold font-heading text-gray-900 border-b border-gray-100 pb-3">
                    Daftar Menu yang Dipesan
                </h3>

                <div class="space-y-3 divide-y divide-gray-100">
                    @foreach($pesanan->detailPesanan as $detail)
                        <div class="pt-3 first:pt-0 flex justify-between items-start text-xs">
                            <div class="space-y-0.5">
                                <h4 class="font-bold text-gray-900 text-sm">
                                    {{ $detail->menu ? $detail->menu->nama_menu : 'Menu Dimsum' }}
                                </h4>
                                <p class="text-rose-600 font-semibold">
                                    {{ $detail->topping ? '+ Topping: ' . $detail->topping->nama_topping : 'Original (Tanpa Topping)' }}
                                </p>
                                <p class="text-gray-400">{{ $detail->jumlah }} porsi x Rp {{ number_format($detail->subtotal / $detail->jumlah, 0, ',', '.') }}</p>
                            </div>
                            <span class="font-bold text-gray-900 text-sm">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <div class="pt-4 border-t border-dashed border-gray-200 flex justify-between items-center text-sm font-extrabold text-gray-900">
                    <span>Total Pembayaran</span>
                    <span class="text-xl text-rose-600 font-heading">{{ $pesanan->formatted_total }}</span>
                </div>
            </div>

            <!-- Customer & Delivery Card -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-200/80 shadow-sm space-y-4">
                <h3 class="text-base font-bold font-heading text-gray-900 border-b border-gray-100 pb-3">
                    Informasi Pengambilan
                </h3>

                <div class="space-y-3 text-xs">
                    <div>
                        <span class="text-gray-400 block">Nama Pemesan</span>
                        <span class="font-bold text-gray-900 text-sm">{{ $pesanan->pelanggan ? $pesanan->pelanggan->nama : '-' }}</span>
                    </div>

                    <div>
                        <span class="text-gray-400 block">Nomor WhatsApp</span>
                        <span class="font-bold text-gray-900">{{ $pesanan->pelanggan ? $pesanan->pelanggan->no_hp : '-' }}</span>
                    </div>

                    <div>
                        <span class="text-gray-400 block">Metode Pengambilan</span>
                        <span class="font-bold text-rose-600 uppercase">
                            {{ $pesanan->metode_pengiriman === 'pickup' ? '🛵 Pickup (Ambil di Outlet)' : '📦 Pesan Ojek Online Mandiri' }}
                        </span>
                    </div>

                    @if($pesanan->metode_pengiriman === 'ojol' && $pesanan->pelanggan && $pesanan->pelanggan->alamat)
                        <div>
                            <span class="text-gray-400 block">Catatan Pengiriman / Alamat</span>
                            <span class="text-gray-700">{{ $pesanan->pelanggan->alamat }}</span>
                        </div>
                    @endif

                    <div class="pt-3 border-t border-gray-100">
                        <span class="text-gray-400 block mb-1">Bukti QRIS yang Diunggah</span>
                        @if($pesanan->bukti_qris_url)
                            <a href="{{ $pesanan->bukti_qris_url }}" target="_blank" class="inline-flex items-center gap-1.5 text-rose-600 hover:text-rose-700 font-bold">
                                <i class="fa-solid fa-image"></i>
                                <span>Lihat Foto Bukti Transfer</span>
                            </a>
                        @else
                            <span class="text-gray-400 italic">Belum ada foto</span>
                        @endif
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
