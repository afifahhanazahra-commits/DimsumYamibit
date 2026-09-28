@extends('layouts.app')

@section('title', 'Dimsum Yamibit - Sensasi Dimsum Mentai & Aneka Saus Spesial')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-br from-dimsum-dark via-slate-900 to-rose-950 text-white py-16 lg:py-24">
    <!-- Decorative Glow Circles -->
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-rose-600/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-amber-500/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Hero Left Content -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md border border-white/15 px-4 py-1.5 rounded-full text-xs font-bold text-amber-300 shadow-inner">
                    <i class="fa-solid fa-fire text-rose-400"></i>
                    <span>Dimsum Ayam & Udang Segar Pilihan #1 di Cirebon</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold font-heading tracking-tight leading-tight">
                    Cita Rasa Dimsum <span class="text-transparent bg-clip-text bg-gradient-to-r from-rose-400 via-amber-300 to-rose-400">Gurih & Lembut</span> yang Bikin Nagih!
                </h1>

                <p class="text-base sm:text-lg text-gray-300 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    Nikmati kelezatan olahan daging ayam dan udang asli tanpa pengawet dengan topping istimewa: Mentai Torched, Chili Oil gurih pedas, Saus Bangkok, hingga Keju Mozarella lumer.
                </p>

                <!-- Store Status Alert in Hero (if closed) -->
                @if(!$storeStatus['is_open'])
                    <div class="p-4 bg-rose-950/70 border-2 border-rose-500/80 rounded-2xl backdrop-blur-md text-left flex items-start gap-3.5 shadow-xl">
                        <div class="w-10 h-10 rounded-xl bg-rose-600 text-white flex items-center justify-center flex-shrink-0 text-lg shadow-md">
                            <i class="fa-solid fa-store-slash"></i>
                        </div>
                        <div class="space-y-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="bg-rose-600 text-white text-[10px] font-extrabold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                                    {{ $storeStatus['status_label'] }}
                                </span>
                                <span class="text-xs text-amber-300 font-bold">Buka: Selasa - Minggu (14.30 - 21.00 WIB)</span>
                            </div>
                            <p class="text-xs text-rose-100 leading-relaxed font-medium">
                                {{ $storeStatus['message'] }} <strong>Fitur pemesanan dinonaktifkan sementara</strong> dan akan otomatis aktif pada jam buka.
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Action CTA -->
                <div class="pt-2 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                    <a href="#menu" class="w-full sm:w-auto btn-gradient text-white px-8 py-4 rounded-2xl font-bold text-base shadow-xl flex items-center justify-center gap-3 group">
                        <span>Lihat Menu & Harga</span>
                        <i class="fa-solid fa-arrow-down group-hover:translate-y-0.5 transition-transform"></i>
                    </a>
                    <a href="#tentang" class="w-full sm:w-auto bg-white/10 hover:bg-white/20 text-white border border-white/20 px-6 py-4 rounded-2xl font-bold text-base backdrop-blur-md transition-all flex items-center justify-center gap-2">
                        <i class="fa-regular fa-circle-question text-rose-400"></i>
                        <span>Keunggulan Kami</span>
                    </a>
                </div>

                <!-- Trust Badges -->
                <div class="pt-6 grid grid-cols-3 gap-4 border-t border-white/10 max-w-lg mx-auto lg:mx-0 text-center">
                    <div>
                        <span class="block text-2xl font-extrabold font-heading text-amber-400">100%</span>
                        <span class="text-xs text-gray-400">Daging Segar Halal</span>
                    </div>
                    <div>
                        <span class="block text-2xl font-extrabold font-heading text-amber-400">0%</span>
                        <span class="text-xs text-gray-400">Bahan Pengawet</span>
                    </div>
                    <div>
                        <span class="block text-2xl font-extrabold font-heading text-amber-400">14.30</span>
                        <span class="text-xs text-gray-400">Jam Buka Toko</span>
                    </div>
                </div>
            </div>

            <!-- Hero Right Visual Banner -->
            <div class="lg:col-span-5 flex justify-center">
                <div class="relative w-full max-w-md">
                    <div class="relative bg-gradient-to-b from-rose-600/30 to-amber-500/20 rounded-3xl p-6 border border-white/20 backdrop-blur-md shadow-2xl">
                        
                        <!-- Food Visual Card (Fitted Frame) -->
                        <div class="rounded-2xl overflow-hidden shadow-lg bg-stone-950 border border-white/10 h-64 sm:h-72 relative flex items-center justify-center p-3">
                            @if(file_exists(public_path('images/menu/dimsum_mentai.jpg')))
                                <img src="{{ asset('images/menu/dimsum_mentai.jpg') }}" alt="" class="absolute inset-0 w-full h-full object-cover blur-xl opacity-40 scale-125 pointer-events-none">
                                <div class="absolute inset-0 bg-stone-950/20 pointer-events-none"></div>
                                <img src="{{ asset('images/menu/dimsum_mentai.jpg') }}" alt="Dimsum Mentai Spesial" class="relative z-10 max-h-full max-w-full object-contain rounded-xl drop-shadow-[0_12px_24px_rgba(0,0,0,0.7)]">
                            @else
                                <div class="text-center p-6 text-rose-300 relative z-10">
                                    <i class="fa-solid fa-bowl-food text-6xl mb-3 text-amber-400"></i>
                                    <p class="font-bold text-white text-lg">Dimsum Mentai Spesial</p>
                                    <p class="text-xs text-gray-300">Best Seller Terlaris di Dimsum Yamibit</p>
                                </div>
                            @endif

                            <div class="absolute top-3 right-3 z-20 bg-rose-600 text-white text-xs font-extrabold px-3 py-1 rounded-full shadow-md">
                                🔥 Paling Laris
                            </div>
                        </div>

                        <!-- Floating Micro Pill with Logo -->
                        <div class="mt-4 bg-white/95 text-slate-900 p-4 rounded-2xl shadow-xl flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('images/logo-circle.png') }}" alt="Dimsum Yamibit" class="w-11 h-11 rounded-full object-cover border-2 border-rose-500 shadow-md">
                                <div>
                                    <p class="text-xs font-bold text-slate-900">Dimsum Mentai Torched</p>
                                    <p class="text-[11px] text-rose-600 font-bold">Mulai Rp 18.000 / porsi</p>
                                </div>
                            </div>
                            @if($storeStatus['is_open'])
                                <button onclick="openMenuOrderModal(2, 'Dimsum Mentai', 18000, 35, '{{ asset('images/menu/dimsum_mentai.jpg') }}')" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold transition-colors">
                                    + Pesan
                                </button>
                            @else
                                <button onclick="showStoreClosedAlert()" class="px-3 py-1.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-xs font-bold transition-colors flex items-center gap-1">
                                    <i class="fa-solid fa-lock text-[10px]"></i> Tutup
                                </button>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Menu Catalog Section -->
<section id="menu" class="py-16 bg-gradient-to-b from-slate-50 to-rose-50/40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-10 space-y-3">
            <span class="text-xs font-extrabold uppercase tracking-widest text-rose-600 bg-rose-100 px-3 py-1 rounded-full">
                Katalog Menu Favorit
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold font-heading text-gray-900">
                Pilih Varian Dimsum & Topping Favoritmu
            </h2>
            <p class="text-sm text-gray-600">
                Semua menu diolah higienis setiap hari dari daging ayam dan udang pilihan. Tambahkan saus ekstra untuk kenikmatan maksimal!
            </p>
        </div>

        @if(!$storeStatus['is_open'])
            <!-- Notice When Store Is Closed -->
            <div class="mb-10 max-w-3xl mx-auto bg-amber-500/10 border-2 border-amber-500/40 rounded-3xl p-5 flex flex-col sm:flex-row items-center gap-4 text-amber-950 shadow-sm">
                <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-xl flex-shrink-0 shadow-md">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div class="text-center sm:text-left flex-1">
                    <div class="flex items-center justify-center sm:justify-start gap-2">
                        <span class="bg-amber-500 text-white text-[10px] font-extrabold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                            {{ $storeStatus['status_label'] }}
                        </span>
                        <h3 class="font-extrabold text-sm sm:text-base text-amber-950">Fitur Pemesanan Sedang Dinonaktifkan</h3>
                    </div>
                    <p class="text-xs sm:text-sm text-amber-900/90 mt-1">
                        Jam operasional Dimsum Yamibit: <strong>Selasa – Minggu, pukul 14.30 – 21.00 WIB</strong> (Senin Libur). Anda tetap dapat melihat menu, dan pemesanan online akan aktif otomatis saat toko buka.
                    </p>
                </div>
            </div>
        @endif

        <!-- Menu Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($menus as $menu)
                @php
                    $stockQty = $menu->stok ? $menu->stok->jumlah_stok : 0;
                    $isAvailable = $menu->status === 'tersedia' && $stockQty > 0;
                @endphp
                <div class="bg-white rounded-3xl border border-gray-200/80 shadow-md hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden group">
                    
                    <!-- Menu Image / Photo Banner (Pas Dengan Bingkai / Fitted Frame) -->
                    <div class="relative h-64 sm:h-72 bg-gradient-to-b from-stone-900 via-zinc-900 to-stone-950 overflow-hidden flex items-center justify-center p-3 group">
                        <!-- Ambient Blurred Backdrop Matching the Food Colors -->
                        <img src="{{ $menu->foto_url }}" alt="" aria-hidden="true" class="absolute inset-0 w-full h-full object-cover blur-2xl opacity-40 scale-125 pointer-events-none select-none">
                        <!-- Subtle Dark Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-stone-950/70 via-transparent to-stone-950/20 pointer-events-none"></div>

                        <!-- Main Food Photo: 100% Contained, Utuh, Pas dengan Bingkai -->
                        <img src="{{ $menu->foto_url }}" alt="{{ $menu->nama_menu }}" class="relative z-10 max-h-full max-w-full object-contain rounded-2xl drop-shadow-[0_12px_24px_rgba(0,0,0,0.6)] group-hover:scale-105 transition-transform duration-500" onerror="this.src='https://images.unsplash.com/photo-1563245372-f21724e3856d?w=600&auto=format&fit=crop&q=80'">
                        
                        <!-- Stock Status Badge Overlay -->
                        <div class="absolute top-3 left-3 z-20">
                            @if(!$isAvailable)
                                <span class="bg-rose-600/95 backdrop-blur-md text-white text-xs font-bold px-3 py-1 rounded-full shadow">
                                    <i class="fa-solid fa-circle-xmark mr-1"></i> Stok Habis
                                </span>
                            @elseif($stockQty <= 10)
                                <span class="bg-amber-500/95 backdrop-blur-md text-white text-xs font-bold px-3 py-1 rounded-full shadow">
                                    <i class="fa-solid fa-triangle-exclamation mr-1"></i> Sisa {{ $stockQty }} Porsi
                                </span>
                            @else
                                <span class="bg-emerald-600/95 backdrop-blur-md text-white text-xs font-bold px-3 py-1 rounded-full shadow">
                                    <i class="fa-solid fa-circle-check mr-1"></i> Tersedia ({{ $stockQty }} porsi)
                                </span>
                            @endif
                        </div>

                        <!-- Price Tag Badge -->
                        <div class="absolute bottom-3 right-3 z-20 bg-white/95 backdrop-blur-md text-slate-900 font-extrabold text-sm px-3.5 py-1.5 rounded-xl shadow-lg border border-white/60">
                            {{ $menu->formatted_harga }}
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                        <div class="space-y-2">
                            <h3 class="text-xl font-extrabold font-heading text-gray-900 group-hover:text-rose-600 transition-colors">
                                {{ $menu->nama_menu }}
                            </h3>
                            <p class="text-xs text-gray-500 leading-relaxed line-clamp-2">
                                {{ $menu->deskripsi ?: 'Dimsum olahan daging ayam dan udang pilihan khas Yamibit Cirebon.' }}
                            </p>
                        </div>

                        <!-- Card Action -->
                        <div class="pt-3 border-t border-gray-100 flex items-center justify-between gap-3">
                            <span class="text-xs font-semibold text-gray-400">Pilihan Saus Tersedia</span>
                            
                            @if(!$storeStatus['is_open'])
                                <button type="button" 
                                    onclick="showStoreClosedAlert()"
                                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-xl text-xs font-bold transition-colors flex items-center gap-1.5 border border-slate-300 shadow-sm">
                                    <i class="fa-solid fa-lock text-rose-500"></i>
                                    <span>Toko Tutup</span>
                                </button>
                            @elseif($isAvailable)
                                <button type="button" 
                                    onclick="openMenuOrderModal({{ $menu->id_menu }}, '{{ addslashes($menu->nama_menu) }}', {{ $menu->harga }}, {{ $stockQty }}, '{{ $menu->foto_url }}')"
                                    class="btn-gradient text-white px-5 py-2.5 rounded-xl text-xs font-bold shadow-md flex items-center gap-1.5">
                                    <i class="fa-solid fa-plus text-[11px]"></i>
                                    <span>Pesan</span>
                                </button>
                            @else
                                <button type="button" disabled class="bg-gray-200 text-gray-400 px-5 py-2.5 rounded-xl text-xs font-bold cursor-not-allowed">
                                    Habis
                                </button>
                            @endif
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

    </div>
</section>

<!-- Story & USP Section -->
<section id="tentang" class="py-16 bg-white border-y border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <div class="lg:col-span-6 space-y-6">
                <span class="text-xs font-extrabold uppercase tracking-widest text-rose-600 bg-rose-50 px-3 py-1 rounded-full border border-rose-200">
                    Cerita Dimsum Yamibit
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold font-heading text-gray-900 leading-tight">
                    Dedikasi Cita Rasa Dimsum Tanpa Kompromi
                </h2>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Dimsum Yamibit hadir sebagai wujud kecintaan kami terhadap olahan kuliner siap saji yang higienis, lezat, dan ramah di kantong. Berawal dari produksi dapur rumahan di Talun, Cirebon, kami berkomitmen hanya menggunakan potongan daging ayam fillet dan udang segar tanpa bahan pengawet sintetis.
                </p>

                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0 mt-0.5 text-xs font-bold">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-900">Tekstur Kenyal & Juicy</h4>
                            <p class="text-xs text-gray-500">Perpaduan daging ayam & udang segar yang padat dan lembut saat dikunyah.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center flex-shrink-0 mt-0.5 text-xs font-bold">
                            <i class="fa-solid fa-fire-burner"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-900">Saus Mentai Torched Khas</h4>
                            <p class="text-xs text-gray-500">Saus mentai dengan proses pembakaran torch menghasilkan aroma *smoky* memikat.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0 mt-0.5 text-xs font-bold">
                            <i class="fa-solid fa-truck-fast"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-900">Pemesanan Mandiri & Praktis</h4>
                            <p class="text-xs text-gray-500">Pesan langsung via web tanpa perlu login, bayar via QRIS, dan koordinasi via WhatsApp.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Visual Cards -->
            <div class="lg:col-span-6 grid grid-cols-2 gap-4">
                <div class="bg-gradient-to-br from-rose-500 to-rose-600 p-6 rounded-3xl text-white space-y-2 shadow-lg flex flex-col justify-between h-48">
                    <i class="fa-solid fa-award text-3xl text-rose-200"></i>
                    <div>
                        <h4 class="text-xl font-bold font-heading">Kualitas Terjamin</h4>
                        <p class="text-xs text-rose-100">Bahan baku pilihan segar setiap hari</p>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-amber-500 to-amber-600 p-6 rounded-3xl text-white space-y-2 shadow-lg flex flex-col justify-between h-48 mt-6">
                    <i class="fa-solid fa-qrcode text-3xl text-amber-200"></i>
                    <div>
                        <h4 class="text-xl font-bold font-heading">Pembayaran QRIS</h4>
                        <p class="text-xs text-amber-100">Support semua e-wallet & mobile banking</p>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-slate-800 to-slate-900 p-6 rounded-3xl text-white space-y-2 shadow-lg flex flex-col justify-between h-48">
                    <i class="fa-solid fa-motorcycle text-3xl text-slate-400"></i>
                    <div>
                        <h4 class="text-xl font-bold font-heading">Pickup / Ojol</h4>
                        <p class="text-xs text-slate-400">Ambil sendiri atau kirim via kurir ojol</p>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-rose-700 to-rose-900 p-6 rounded-3xl text-white space-y-2 shadow-lg flex flex-col justify-between h-48 mt-6">
                    <i class="fa-solid fa-headset text-3xl text-rose-300"></i>
                    <div>
                        <h4 class="text-xl font-bold font-heading">Direct WhatsApp</h4>
                        <p class="text-xs text-rose-200">Konfirmasi cepat dengan pengelola toko</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Location & Contact Section -->
<section id="lokasi" class="py-16 bg-slate-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-slate-800/80 border border-slate-700 rounded-3xl p-8 lg:p-12 shadow-2xl">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                
                <div class="space-y-4">
                    <span class="text-xs font-bold tracking-widest text-amber-400 uppercase">Outlet Dimsum Yamibit</span>
                    <h3 class="text-3xl font-extrabold font-heading">Kunjungi Outlet Kami di Talun Cirebon</h3>
                    <p class="text-sm text-gray-300 leading-relaxed">
                        Anda dapat mengambil langsung pesanan yang telah dikonfirmasi (metode Pickup) di lokasi outlet kami atau memesan driver ojol mandiri untuk penjemputan.
                    </p>

                    <div class="pt-2 space-y-2.5 text-sm text-gray-300">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-location-dot text-rose-400 w-5"></i>
                            <span>Arumsari, Jl. Jembatan Merah No.02, Kecomberan, Talun, Cirebon</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-phone text-emerald-400 w-5"></i>
                            <span>WhatsApp: 08990745953</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fa-regular fa-clock text-amber-400 w-5"></i>
                            <span>Setiap Hari: 10:00 - 21:00 WIB</span>
                        </div>
                    </div>

                    <div class="pt-4">
                        <a href="https://maps.google.com/?q=Arumsari+Jl.+Jembatan+Merah+No.02+Kecomberan+Talun+Cirebon" target="_blank" class="inline-flex items-center gap-2 bg-white text-slate-900 hover:bg-rose-50 px-6 py-3 rounded-xl font-bold text-xs shadow-md transition-colors">
                            <i class="fa-solid fa-map-location-dot text-rose-600"></i>
                            <span>Buka di Google Maps</span>
                        </a>
                    </div>
                </div>

                <!-- Google Maps Frame Simulation -->
                <div class="rounded-2xl overflow-hidden border border-slate-700 bg-slate-950 p-4 text-center space-y-3">
                    <div class="w-12 h-12 rounded-full bg-rose-500/20 text-rose-400 flex items-center justify-center mx-auto text-xl">
                        <i class="fa-solid fa-map-pin"></i>
                    </div>
                    <h4 class="font-bold text-base text-white">Outlet Dimsum Yamibit</h4>
                    <p class="text-xs text-gray-400">Jl. Jembatan Merah No. 02, Kecomberan, Talun, Cirebon</p>
                    <div class="pt-2">
                        <span class="inline-block bg-emerald-500/20 text-emerald-300 text-xs px-3 py-1 rounded-full font-semibold">
                            ● Buka Sekarang (Siap Melayani Pesanan)
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Modal: Select Topping & Add to Cart -->
<div id="menu-order-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeMenuOrderModal()"></div>

    <!-- Dialog -->
    <div class="relative bg-white rounded-3xl max-w-md w-full max-h-[90vh] overflow-y-auto p-6 shadow-2xl space-y-6 z-10 animate-fade-in">
        
        <!-- Modal Header -->
        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
            <div>
                <h3 id="modal-menu-name" class="text-xl font-extrabold font-heading text-gray-900 leading-tight">Nama Menu</h3>
                <p id="modal-menu-price" class="text-sm font-bold text-rose-600">Rp 0</p>
            </div>
            <button type="button" onclick="closeMenuOrderModal()" class="text-gray-400 hover:text-gray-600 p-1">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <!-- Menu Photo Preview (Pas Dengan Bingkai / Fitted Frame) -->
        <div class="relative h-48 rounded-2xl overflow-hidden flex items-center justify-center bg-stone-950 p-2 border border-slate-200/60 shadow-inner">
            <img id="modal-menu-img-blur" src="" alt="" class="absolute inset-0 w-full h-full object-cover blur-xl opacity-40 scale-125 pointer-events-none">
            <div class="absolute inset-0 bg-stone-950/20 pointer-events-none"></div>
            <img id="modal-menu-img" src="" alt="Menu Dimsum" class="relative z-10 max-h-full max-w-full object-contain rounded-xl drop-shadow-[0_8px_16px_rgba(0,0,0,0.5)]">
        </div>

        <!-- Hidden Data Holders -->
        <input type="hidden" id="modal-menu-id">
        <input type="hidden" id="modal-base-price">
        <input type="hidden" id="modal-menu-foto">
        <input type="hidden" id="modal-max-stock">

        <!-- Topping Options -->
        <div class="space-y-3">
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                Pilih Varian Saus / Topping Tambahan
            </label>
            
            <div class="space-y-2">
                <!-- Option: Tanpa Topping / Original -->
                <label class="flex items-center justify-between p-3 rounded-xl border border-gray-200 hover:border-rose-300 cursor-pointer bg-gray-50/50 has-[:checked]:bg-rose-50 has-[:checked]:border-rose-500 transition-all">
                    <div class="flex items-center gap-3">
                        <input type="radio" name="modal_topping" value="" data-price="0" data-name="" checked onchange="recalculateModalSubtotal()" class="text-rose-600 focus:ring-rose-500 w-4 h-4">
                        <span class="text-sm font-bold text-gray-800">Original (Tanpa Topping Ekstra)</span>
                    </div>
                    <span class="text-xs font-semibold text-gray-500">+Rp 0</span>
                </label>

                @foreach($toppings as $topping)
                    <label class="flex items-center justify-between p-3 rounded-xl border border-gray-200 hover:border-rose-300 cursor-pointer bg-gray-50/50 has-[:checked]:bg-rose-50 has-[:checked]:border-rose-500 transition-all">
                        <div class="flex items-center gap-3">
                            <input type="radio" name="modal_topping" value="{{ $topping->id_topping }}" data-price="{{ $topping->harga_tambahan }}" data-name="{{ $topping->nama_topping }}" onchange="recalculateModalSubtotal()" class="text-rose-600 focus:ring-rose-500 w-4 h-4">
                            <span class="text-sm font-bold text-gray-800">{{ $topping->nama_topping }}</span>
                        </div>
                        <span class="text-xs font-bold text-rose-600">{{ $topping->formatted_harga }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Quantity Selector -->
        <div class="flex items-center justify-between pt-2">
            <div>
                <span class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Jumlah Porsi</span>
                <span id="modal-stock-hint" class="text-[11px] text-gray-400">Tersedia 0 porsi</span>
            </div>

            <div class="flex items-center border border-gray-300 rounded-xl bg-gray-50 overflow-hidden">
                <button type="button" onclick="changeModalQty(-1)" class="w-9 h-9 flex items-center justify-center text-gray-600 hover:bg-gray-200 font-bold">-</button>
                <input type="number" id="modal-qty" value="1" min="1" readonly class="w-12 text-center text-sm font-bold text-gray-900 bg-transparent border-0 focus:ring-0">
                <button type="button" onclick="changeModalQty(1)" class="w-9 h-9 flex items-center justify-center text-gray-600 hover:bg-gray-200 font-bold">+</button>
            </div>
        </div>

        <!-- Subtotal & Submit Button -->
        <div class="pt-4 border-t border-gray-100 flex items-center justify-between gap-4">
            <div>
                <span class="block text-[11px] text-gray-500 font-medium">Subtotal Item</span>
                <span id="modal-subtotal" class="text-xl font-extrabold font-heading text-rose-600">Rp 0</span>
            </div>

            <button type="button" onclick="addModalItemToCart()" class="btn-gradient text-white px-6 py-3 rounded-xl font-bold text-sm shadow-md flex items-center gap-2">
                <i class="fa-solid fa-cart-plus"></i>
                <span>Masukkan Keranjang</span>
            </button>
        </div>

    </div>
</div>

<!-- Modal: Peringatan Toko Tutup -->
<div id="store-closed-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeStoreClosedAlert()"></div>
    <div class="relative bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl space-y-6 z-10 text-center animate-fade-in border border-rose-100">
        <div class="w-16 h-16 rounded-3xl bg-rose-100 text-rose-600 flex items-center justify-center text-2xl mx-auto shadow-lg shadow-rose-600/20">
            <i class="fa-solid fa-store-slash"></i>
        </div>
        
        <div class="space-y-2">
            <span class="inline-block bg-rose-100 text-rose-700 text-xs font-extrabold px-3 py-1 rounded-full uppercase tracking-wider">
                {{ $storeStatus['status_label'] }}
            </span>
            <h3 class="text-xl font-extrabold font-heading text-gray-900">
                Fitur Pemesanan Sedang Ditutup
            </h3>
            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                {{ $storeStatus['message'] }}
            </p>
        </div>

        <div class="bg-amber-50 rounded-2xl p-4 border border-amber-200 text-left space-y-2">
            <div class="flex items-center gap-2 text-xs font-bold text-amber-900">
                <i class="fa-regular fa-clock text-amber-600"></i>
                <span>Jadwal Operasional Dimsum Yamibit:</span>
            </div>
            <p class="text-xs text-amber-800 leading-relaxed">
                • <strong>Selasa – Minggu:</strong> 14.30 – 21.00 WIB<br>
                • <strong>Senin:</strong> Libur / Tutup
            </p>
            @if($storeStatus['next_open'])
                <p class="text-[11px] font-semibold text-rose-600 pt-1 border-t border-amber-200/60">
                    🥟 Buka Kembali: {{ $storeStatus['next_open'] }}
                </p>
            @endif
        </div>

        <div class="flex flex-col sm:flex-row gap-3 pt-2">
            <button type="button" onclick="closeStoreClosedAlert()" class="flex-1 px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs rounded-xl transition-colors">
                Tutup Peringatan
            </button>
            <a href="https://wa.me/628990745953?text=Halo%20Dimsum%20Yamibit,%20apakah%20bisa%20pre-order%20untuk%20jam%20buka%20nanti?" target="_blank" class="flex-1 px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl transition-colors flex items-center justify-center gap-1.5 shadow-md">
                <i class="fa-brands fa-whatsapp text-sm"></i>
                <span>Chat Admin</span>
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let currentModalMaxStock = 100;

    function showStoreClosedAlert() {
        document.getElementById('store-closed-modal').classList.remove('hidden');
    }

    function closeStoreClosedAlert() {
        document.getElementById('store-closed-modal').classList.add('hidden');
    }

    function openMenuOrderModal(id, name, price, stock, foto) {
        document.getElementById('modal-menu-id').value = id;
        document.getElementById('modal-menu-name').innerText = name;
        document.getElementById('modal-base-price').value = price;
        document.getElementById('modal-menu-foto').value = foto;
        document.getElementById('modal-max-stock').value = stock;
        currentModalMaxStock = stock;

        // Update photo preview
        const imgEl = document.getElementById('modal-menu-img');
        const imgBlurEl = document.getElementById('modal-menu-img-blur');
        if (imgEl && foto) imgEl.src = foto;
        if (imgBlurEl && foto) imgBlurEl.src = foto;

        document.getElementById('modal-menu-price').innerText = 'Rp ' + price.toLocaleString('id-ID');
        document.getElementById('modal-stock-hint').innerText = `Maksimal pemesanan: ${stock} porsi`;
        document.getElementById('modal-qty').value = 1;

        // Reset radio to original
        const radios = document.getElementsByName('modal_topping');
        if (radios.length > 0) {
            radios[0].checked = true;
        }

        recalculateModalSubtotal();
        document.getElementById('menu-order-modal').classList.remove('hidden');
    }

    function closeMenuOrderModal() {
        document.getElementById('menu-order-modal').classList.add('hidden');
    }

    function changeModalQty(delta) {
        const qtyEl = document.getElementById('modal-qty');
        let qty = parseInt(qtyEl.value) || 1;
        qty += delta;

        if (qty < 1) qty = 1;
        if (qty > currentModalMaxStock) {
            alert(`Mohon maaf, stok maksimal yang tersedia hanya ${currentModalMaxStock} porsi.`);
            qty = currentModalMaxStock;
        }

        qtyEl.value = qty;
        recalculateModalSubtotal();
    }

    function recalculateModalSubtotal() {
        const basePrice = parseInt(document.getElementById('modal-base-price').value) || 0;
        const qty = parseInt(document.getElementById('modal-qty').value) || 1;

        const selectedTopping = document.querySelector('input[name="modal_topping"]:checked');
        const toppingPrice = selectedTopping ? parseInt(selectedTopping.getAttribute('data-price')) || 0 : 0;

        const subtotal = (basePrice + toppingPrice) * qty;
        document.getElementById('modal-subtotal').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
    }

    function addModalItemToCart() {
        const menuId = parseInt(document.getElementById('modal-menu-id').value);
        const name = document.getElementById('modal-menu-name').innerText;
        const price = parseInt(document.getElementById('modal-base-price').value);
        const foto = document.getElementById('modal-menu-foto').value;
        const qty = parseInt(document.getElementById('modal-qty').value) || 1;

        const selectedTopping = document.querySelector('input[name="modal_topping"]:checked');
        const toppingId = selectedTopping && selectedTopping.value ? parseInt(selectedTopping.value) : null;
        const toppingName = selectedTopping ? selectedTopping.getAttribute('data-name') : '';
        const toppingPrice = selectedTopping ? parseInt(selectedTopping.getAttribute('data-price')) || 0 : 0;

        const cart = getCart();

        // Check if same menu + topping already exists in cart
        const existingIndex = cart.findIndex(item => item.id_menu === menuId && item.id_topping === toppingId);
        if (existingIndex > -1) {
            cart[existingIndex].qty += qty;
        } else {
            cart.push({
                id_menu: menuId,
                id_topping: toppingId,
                name: name,
                price: price,
                toppingName: toppingName,
                toppingPrice: toppingPrice,
                qty: qty,
                foto: foto
            });
        }

        saveCart(cart);
        closeMenuOrderModal();
        openCartModal();
    }
</script>
@endsection
