<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DimsumYamibit — Dimsum &amp; Yamibit Lezat</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-orange-50 text-gray-800 antialiased">
    {{-- ============ NAVBAR ============ --}}
    <nav class="fixed top-0 inset-x-0 z-40 bg-white/90 backdrop-blur-md border-b border-orange-100 shadow-sm">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between">
            <a href="#home" class="flex items-center gap-2">
                <span class="w-10 h-10 rounded-full bg-gradient-to-br from-red-500 to-orange-400 flex items-center justify-center text-white font-black text-lg shadow-md">DY</span>
                <span class="font-extrabold text-xl tracking-tight text-gray-900">Dimsum<span class="text-orange-500">Yamibit</span></span>
            </a>
            <div class="hidden md:flex items-center gap-8 text-sm font-semibold text-gray-600">
                <a href="#home" class="hover:text-orange-500 transition">Home</a>
                <a href="#menu" class="hover:text-orange-500 transition">Menu</a>
                <button type="button" onclick="openFlyer()" class="hover:text-orange-500 transition font-semibold">Flyer Menu</button>
                <a href="#qris" class="hover:text-orange-500 transition">QRIS</a>
                <a href="#review" class="hover:text-orange-500 transition">Review</a>
            </div>
            <div class="md:hidden flex items-center gap-2">
                <button type="button" onclick="openFlyer()" class="px-3 py-1.5 bg-orange-100 text-orange-700 text-xs font-bold rounded-lg hover:bg-orange-200 transition">
                    Flyer
                </button>
                <a href="#menu" class="inline-flex px-3.5 py-1.5 bg-orange-500 text-white text-xs font-bold rounded-lg shadow hover:bg-orange-600 transition">
                    Pesan
                </a>
            </div>
        </div>
    </nav>

    {{-- ============ HERO ============ --}}
    <header id="home" class="relative pt-24 pb-16 px-4 sm:px-6 overflow-hidden">
        {{-- Decorative blobs --}}
        <div class="absolute -top-20 -right-20 w-72 h-72 bg-orange-200 rounded-full blur-3xl opacity-60"></div>
        <div class="absolute top-40 -left-20 w-72 h-72 bg-red-200 rounded-full blur-3xl opacity-50"></div>

        <div class="relative max-w-6xl mx-auto grid md:grid-cols-2 gap-10 items-center">
            <div class="text-center md:text-left">
                <span class="inline-block px-3 py-1 bg-orange-500 text-white text-xs font-bold rounded-full uppercase tracking-wider mb-4">Dimsum &amp; Yamibit</span>
                <h1 class="text-4xl sm:text-5xl font-black text-gray-900 leading-tight">
                    Nikmati Lezatnya <span class="text-orange-500">Dimsum</span> Hangat
                    <span class="block text-2xl sm:text-3xl font-bold text-gray-600 mt-2">Setiap Hari, Siap Antar!</span>
                </h1>
                <p class="mt-4 text-gray-600 leading-relaxed max-w-md mx-auto md:mx-0">
                    Dimsum kukus lembut, dimsum goreng keju lumer, mentai platter, dan bola ayam keju buatan tangan dengan bahan berkualitas. Pesan via WhatsApp sekarang!
                </p>
                <div class="mt-8 flex flex-wrap gap-3 justify-center md:justify-start">
                    <a href="#menu" class="inline-flex items-center gap-2 px-6 py-3 bg-orange-500 text-white font-bold rounded-xl shadow-lg shadow-orange-200 hover:bg-orange-600 hover:-translate-y-0.5 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>
                        Pesan Sekarang
                    </a>
                    <button type="button" onclick="openFlyer()" class="inline-flex items-center gap-2 px-5 py-3 bg-amber-50 text-amber-900 font-bold rounded-xl border-2 border-amber-200 hover:bg-amber-100 hover:-translate-y-0.5 transition">
                        📜 Flyer Menu
                    </button>
                    <a href="#qris" class="inline-flex items-center gap-2 px-5 py-3 bg-white text-gray-700 font-bold rounded-xl border-2 border-orange-200 hover:border-orange-400 hover:-translate-y-0.5 transition">
                        QRIS
                    </a>
                </div>
            </div>

            <div class="relative flex justify-center">
                <div class="w-72 h-72 sm:w-80 sm:h-80 rounded-full bg-gradient-to-br from-red-400 to-orange-300 overflow-hidden shadow-2xl shadow-orange-200 flex items-center justify-center border-4 border-white">
                    <img src="{{ asset('images/menu/original-personal.jpg') }}"
                         alt="Dimsum Original DimsumYamibit" class="w-full h-full object-cover">
                </div>
                <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 bg-white rounded-2xl shadow-xl px-5 py-3 flex items-center gap-3 border border-orange-100">
                    <span class="text-3xl">🥟</span>
                    <div>
                        <p class="text-xs font-semibold text-gray-500">Dimsum Original</p>
                        <p class="text-sm font-black text-orange-500">Mulai Rp 21.000 (Isi 6)</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- ============ MENU KATALOG ============ --}}
    <section id="menu" class="py-14 px-4 sm:px-6 bg-white">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-10">
                <span class="text-orange-500 font-bold uppercase tracking-widest text-sm">Menu Kami</span>
                <h2 class="text-3xl sm:text-4xl font-black text-gray-900 mt-2">Pilih Menu Favoritmu</h2>
                <p class="text-gray-500 mt-2">Klik "+" untuk menambah ke keranjang, lalu kirim pesanan via WhatsApp.</p>
            </div>

            @forelse ($menus as $kategori => $daftarMenu)
                <div class="mb-12">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="px-4 py-1.5 bg-orange-100 text-orange-600 font-bold rounded-full text-sm">{{ $kategori }}</span>
                        <div class="flex-1 h-px bg-orange-100"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($daftarMenu as $menu)
                            <div class="menu-card bg-white rounded-2xl border border-orange-100 shadow-sm overflow-hidden hover:shadow-xl hover:-translate-y-1 transition duration-300 flex flex-col"
                                 data-id="{{ $menu->id }}"
                                 data-nama="{{ $menu->nama }}"
                                 data-harga="{{ $menu->harga }}">
                                <div class="relative h-48 overflow-hidden bg-orange-50">
                                    <img src="{{ str_starts_with($menu->foto ?? '', 'http') ? $menu->foto : asset(ltrim($menu->foto ?? '', '/')) }}"
                                         alt="{{ $menu->nama }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                    @if ($menu->isAvailable())
                                        <span class="absolute top-3 left-3 px-2.5 py-1 bg-green-500 text-white text-xs font-bold rounded-full shadow">Tersedia</span>
                                    @else
                                        <span class="absolute top-3 left-3 px-2.5 py-1 bg-gray-500 text-white text-xs font-bold rounded-full shadow">Habis</span>
                                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                            <span class="px-4 py-2 bg-white text-gray-700 font-black rounded-lg">STOK HABIS</span>
                                        </div>
                                    @endif
                                    <span class="absolute top-3 right-3 px-2.5 py-1 bg-white/90 text-orange-600 text-sm font-black rounded-lg shadow">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
                                </div>

                                <div class="p-5 flex flex-col flex-1">
                                    <h3 class="font-extrabold text-lg text-gray-900">{{ $menu->nama }}</h3>
                                    <p class="text-sm text-gray-500 mt-1.5 leading-relaxed flex-1">{{ $menu->deskripsi }}</p>

                                    <div class="mt-4 flex items-center justify-between gap-3">
                                        <div class="flex items-center gap-1 border border-orange-200 rounded-lg p-1">
                                            <button type="button" class="qty-btn w-8 h-8 rounded-md bg-orange-100 text-orange-600 font-bold hover:bg-orange-200 transition" data-action="decrease">−</button>
                                            <span class="qty w-8 text-center font-bold text-gray-800">0</span>
                                            <button type="button" class="qty-btn w-8 h-8 rounded-md bg-orange-500 text-white font-bold hover:bg-orange-600 transition" data-action="increase">+</button>
                                        </div>
                                        <button type="button" class="add-cart flex-1 px-3 py-2 bg-orange-500 text-white text-sm font-bold rounded-lg hover:bg-orange-600 transition disabled:opacity-40 disabled:cursor-not-allowed"
                                                @if(!$menu->isAvailable()) disabled @endif>
                                            Tambah ke Keranjang
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="text-center py-16 text-gray-400">
                    <p class="text-5xl mb-4">🍽️</p>
                    <p class="font-semibold">Belum ada menu tersedia.</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- ============ QRIS SECTION ============ --}}
    <section id="qris" class="py-14 px-4 sm:px-6 bg-orange-50">
        <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-10 items-center">
            <div>
                <span class="text-orange-500 font-bold uppercase tracking-widest text-sm">Pembayaran</span>
                <h2 class="text-3xl sm:text-4xl font-black text-gray-900 mt-2">Bayar Mudah dengan QRIS</h2>
                <p class="text-gray-600 mt-3 leading-relaxed">
                    Scan QRIS untuk pembayaran cepat dan aman. Anda juga bisa membayar di tempat saat takeaway.
                </p>
                <ul class="mt-5 space-y-3 text-gray-700">
                    <li class="flex items-start gap-3"><span class="text-orange-500 font-bold">✓</span> Pindai kode QRIS yang tersedia.</li>
                    <li class="flex items-start gap-3"><span class="text-orange-500 font-bold">✓</span> Masukkan nominal total pesanan Anda.</li>
                    <li class="flex items-start gap-3"><span class="text-orange-500 font-bold">✓</span> Konfirmasi pembayaran kepada admin kami.</li>
                </ul>
                <button type="button" onclick="openQris()" class="mt-6 inline-flex items-center gap-2 px-6 py-3 bg-gray-900 text-white font-bold rounded-xl hover:bg-gray-800 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 11h8V3H3v8zm2-6h4v4H5V5zm8-2v8h8V3h-8zm6 6h-4V5h4v4zM3 21h8v-8H3v8zm2-6h4v4H5v-4zm13-2h-2v3h-2v2h2v2h2v-2h2v-2h-2v-3zm-5 2h2v2h-2v-2zm2 4h2v2h-2v-2z"/></svg>
                    Lihat QRIS Toko
                </button>
            </div>
            <div class="flex justify-center">
                <div class="bg-white rounded-2xl shadow-xl p-6 w-64">
                    <img src="{{ asset('images/qris.jpg') }}"
                         alt="QRIS DimsumYamibit" class="w-full h-full">
                    <p class="text-center text-sm font-semibold text-gray-600 mt-3">Scan untuk membayar</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ REVIEW SECTION ============ --}}
    <section id="review" class="py-14 px-4 sm:px-6 bg-white">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-10">
                <span class="text-orange-500 font-bold uppercase tracking-widest text-sm">Testimoni</span>
                <h2 class="text-3xl sm:text-4xl font-black text-gray-900 mt-2">Apa Kata Pelanggan</h2>
                @if ($reviewCount > 0)
                    <div class="mt-3 inline-flex items-center gap-2 bg-orange-50 rounded-full px-4 py-2">
                        <span class="text-2xl">⭐</span>
                        <span class="font-black text-gray-900">{{ number_format($averageRating, 1) }}</span>
                        <span class="text-gray-500 text-sm">dari {{ $reviewCount }} ulasan</span>
                    </div>
                @endif
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                {{-- List of reviews --}}
                <div>
                    @if ($reviews->isEmpty())
                        <p class="text-gray-400 text-center py-8">Belum ada ulasan. Jadilah yang pertama!</p>
                    @else
                        <div class="space-y-4 max-h-[540px] overflow-y-auto pr-2 no-scrollbar">
                            @foreach ($reviews as $review)
                                <div class="bg-orange-50 rounded-2xl p-5 border border-orange-100">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center gap-2">
                                            <span class="w-9 h-9 rounded-full bg-orange-500 text-white flex items-center justify-center font-black">{{ strtoupper(substr($review->nama_pelanggan, 0, 1)) }}</span>
                                            <span class="font-bold text-gray-900">{{ $review->nama_pelanggan }}</span>
                                        </div>
                                        <div class="flex text-amber-400">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span class="{{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-300' }}">★</span>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-gray-600 text-sm leading-relaxed">{{ $review->komentar }}</p>
                                    <p class="text-xs text-gray-400 mt-2">{{ $review->created_at->diffForHumans() }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Review form --}}
                <div class="bg-white rounded-2xl border border-orange-100 shadow-sm p-6">
                    <h3 class="font-extrabold text-xl text-gray-900 mb-1">Tulis Ulasan Anda</h3>
                    <p class="text-sm text-gray-500 mb-5">Bagikan pengalamanmu menikmati DimsumYamibit!</p>

                    @if (session('success'))
                        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm font-semibold rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('review.store') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Anda</label>
                            <input type="text" name="nama_pelanggan" value="{{ old('nama_pelanggan') }}" required
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-300 focus:border-orange-400 transition"
                                   placeholder="Nama lengkap">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Rating</label>
                            <div class="flex flex-row-reverse justify-end gap-1 star-input" id="star-rating">
                                @for ($i = 5; $i >= 1; $i--)
                                    <input type="radio" name="rating" value="{{ $i }}" id="star-{{ $i }}" class="sr-only" @if(old('rating') == $i) checked @endif>
                                    <label for="star-{{ $i }}" class="text-3xl cursor-pointer text-gray-300 hover:text-amber-400 transition" data-value="{{ $i }}">★</label>
                                @endfor
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Komentar</label>
                            <textarea name="komentar" rows="3" required
                                      class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-300 focus:border-orange-400 transition resize-none"
                                      placeholder="Ceritakan pengalamanmu...">{{ old('komentar') }}</textarea>
                        </div>
                        <button type="submit" class="w-full px-6 py-3 bg-orange-500 text-white font-bold rounded-xl hover:bg-orange-600 transition shadow-lg shadow-orange-200">
                            Kirim Ulasan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ FOOTER ============ --}}
    <footer class="bg-gray-900 text-gray-300 py-10 px-4 sm:px-6">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-2">
                <span class="w-9 h-9 rounded-full bg-gradient-to-br from-red-500 to-orange-400 flex items-center justify-center text-white font-black">DY</span>
                <span class="font-extrabold text-lg text-white">Dimsum<span class="text-orange-400">Yamibit</span></span>
            </div>
            <div class="text-center md:text-left text-sm text-gray-400">
                <p class="text-white font-semibold flex items-center justify-center md:justify-start gap-1">
                    📍 Jl. Jembatan merah talun
                </p>
                <p class="mt-1">© {{ date('Y') }} DimsumYamibit. All rights reserved.</p>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" onclick="openFlyer()" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-gray-200 text-sm font-bold rounded-lg transition border border-gray-700">
                    Flyer Menu
                </button>
                <a href="https://wa.me/628990745953" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-lg transition shadow-md shadow-green-900/30">
                    💬 WhatsApp Admin
                </a>
            </div>
        </div>
    </footer>

    {{-- ============ QRIS MODAL ============ --}}
    <div id="qris-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeQris()"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-sm w-full p-6">
            <button type="button" onclick="closeQris()" class="absolute top-3 right-3 w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 transition">✕</button>
            <h3 class="font-extrabold text-xl text-gray-900 text-center mb-1">Pembayaran QRIS</h3>
            <p class="text-sm text-gray-500 text-center mb-4">Scan kode dibawah untuk membayar</p>
            <div class="bg-white border-2 border-dashed border-orange-200 rounded-2xl p-4">
                <img src="{{ asset('images/qris.jpg') }}"
                     alt="QRIS DimsumYamibit" class="w-full">
            </div>
            <ul class="mt-4 space-y-2 text-sm text-gray-600">
                <li class="flex gap-2"><span class="text-orange-500 font-bold">1.</span> Buka aplikasi e-wallet / m-banking Anda.</li>
                <li class="flex gap-2"><span class="text-orange-500 font-bold">2.</span> Pilih menu "Scan" atau "QRIS".</li>
                <li class="flex gap-2"><span class="text-orange-500 font-bold">3.</span> Masukkan nominal total pesanan dan konfirmasi.</li>
            </ul>
            <button type="button" onclick="closeQris()" class="mt-5 w-full px-5 py-3 bg-gray-900 text-white font-bold rounded-xl hover:bg-gray-800 transition">Tutup</button>
        </div>
    </div>

    {{-- ============ FLYER MENU MODAL ============ --}}
    <div id="flyer-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" onclick="closeFlyer()"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full p-4 overflow-hidden max-h-[90vh] flex flex-col z-10">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <h3 class="font-extrabold text-lg text-gray-900">Flyer Menu Resmi DimsumYamibit</h3>
                <button type="button" onclick="closeFlyer()" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 transition">✕</button>
            </div>
            <div class="overflow-y-auto py-3 flex-1 text-center">
                <img src="{{ asset('images/menu/menu-flyer.jpg') }}" alt="Flyer Menu DimsumYamibit" class="w-full rounded-xl shadow-md mx-auto">
            </div>
            <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                <span class="text-xs text-gray-500">📍 Jl. Jembatan merah talun</span>
                <button type="button" onclick="closeFlyer()" class="px-4 py-2 bg-gray-900 text-white font-bold text-sm rounded-lg hover:bg-gray-800 transition">Tutup</button>
            </div>
        </div>
    </div>

    {{-- ============ STICKY ORDER BAR / CART ============ --}}
    <div id="order-bar" class="fixed bottom-0 inset-x-0 z-40 hidden">
        <div class="max-w-6xl mx-auto px-4 pb-4">
            <div class="bg-white rounded-2xl shadow-2xl border border-orange-100 overflow-hidden">
                {{-- Header --}}
                <button type="button" onclick="toggleCart()" class="w-full flex items-center justify-between px-5 py-3 bg-orange-500 text-white">
                    <span class="flex items-center gap-2 font-bold"><span class="cart-icon">🛒</span> Keranjang Pesanan <span class="cart-count-badge bg-white text-orange-600 text-xs font-black rounded-full px-2 py-0.5">0</span></span>
                    <span id="cart-toggle-label" class="text-sm font-bold">Lihat Detail</span>
                </button>

                {{-- Cart body --}}
                <div id="cart-body" class="hidden">
                    <div class="p-5 max-h-64 overflow-y-auto no-scrollbar">
                        <div id="cart-items" class="divide-y divide-gray-100">
                            <p class="text-gray-400 text-sm text-center py-4">Keranjang masih kosong.</p>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between">
                            <span class="font-bold text-gray-700">Total</span>
                            <span id="cart-total" class="font-black text-orange-600 text-xl">Rp 0</span>
                        </div>
                    </div>

                    {{-- Customer form --}}
                    <div class="px-5 pb-5 space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Penerima</label>
                            <input type="text" id="customer-name" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-300 focus:border-orange-400 transition" placeholder="Nama lengkap">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Mode Pengiriman</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="flex items-center gap-2 border border-gray-200 rounded-xl px-3 py-2.5 cursor-pointer has-[:checked]:border-orange-500 has-[:checked]:bg-orange-50 transition">
                                    <input type="radio" name="delivery_mode" value="Jalan Kaki / Takeaway" checked class="accent-orange-500">
                                    <span class="text-sm font-semibold">Takeaway</span>
                                </label>
                                <label class="flex items-center gap-2 border border-gray-200 rounded-xl px-3 py-2.5 cursor-pointer has-[:checked]:border-orange-500 has-[:checked]:bg-orange-50 transition">
                                    <input type="radio" name="delivery_mode" value="Ojol (GoFood/Grab)" class="accent-orange-500">
                                    <span class="text-sm font-semibold">Ojol</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Pengiriman</label>
                            <textarea id="customer-address" rows="2" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-300 focus:border-orange-400 transition resize-none" placeholder="Alamat lengkap (untuk pengiriman)"></textarea>
                        </div>
                        <button type="button" onclick="sendWhatsApp()" class="w-full px-6 py-3.5 bg-green-500 text-white font-black rounded-xl hover:bg-green-600 transition shadow-lg shadow-green-200 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            Kirim Pesanan via WhatsApp
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============ SCRIPTS ============ --}}
    <script>
        // ---- Flyer Modal ----
        function openFlyer() {
            const modal = document.getElementById('flyer-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        function closeFlyer() {
            const modal = document.getElementById('flyer-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // ---- QRIS Modal ----
        function openQris() {
            const modal = document.getElementById('qris-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        function closeQris() {
            const modal = document.getElementById('qris-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // ---- Cart state ----
        const cart = {}; // { menuId: { nama, harga, qty } }
        const WA_NUMBER = '628990745953';

        const qtyBtns = document.querySelectorAll('.qty-btn');
        const addBtns = document.querySelectorAll('.add-cart');

        qtyBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const card = this.closest('.menu-card');
                const qtyEl = card.querySelector('.qty');
                let qty = parseInt(qtyEl.textContent);
                if (this.dataset.action === 'increase') {
                    qty = Math.min(qty + 1, 99);
                } else {
                    qty = Math.max(qty - 1, 0);
                }
                qtyEl.textContent = qty;
            });
        });

        addBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const card = this.closest('.menu-card');
                const id = parseInt(card.dataset.id);
                const nama = card.dataset.nama;
                const harga = parseFloat(card.dataset.harga);
                const qty = parseInt(card.querySelector('.qty').textContent);

                if (qty <= 0) return;

                if (cart[id]) {
                    cart[id].qty += qty;
                } else {
                    cart[id] = { nama, harga, qty };
                }
                card.querySelector('.qty').textContent = 0;
                renderCart();
                showOrderBar();
            });
        });

        function renderCart() {
            const items = document.getElementById('cart-items');
            const totalEl = document.getElementById('cart-total');
            const badge = document.querySelector('.cart-count-badge');
            let total = 0;
            let count = 0;
            items.innerHTML = '';

            const ids = Object.keys(cart);
            if (ids.length === 0) {
                items.innerHTML = '<p class="text-gray-400 text-sm text-center py-4">Keranjang masih kosong.</p>';
                totalEl.textContent = 'Rp 0';
                badge.textContent = '0';
                return;
            }

            ids.forEach(id => {
                const item = cart[id];
                const subtotal = item.harga * item.qty;
                total += subtotal;
                count += item.qty;

                const row = document.createElement('div');
                row.className = 'flex items-center justify-between py-3 gap-3';
                row.innerHTML = `
                    <div class="flex-1">
                        <p class="font-bold text-gray-800 text-sm">${item.nama}</p>
                        <p class="text-xs text-gray-500">Rp ${formatRupiah(item.harga)} × ${item.qty}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="w-7 h-7 rounded-md bg-orange-100 text-orange-600 font-bold hover:bg-orange-200 transition" onclick="changeQty(${id}, -1)">−</button>
                        <span class="w-6 text-center font-bold text-sm">${item.qty}</span>
                        <button class="w-7 h-7 rounded-md bg-orange-500 text-white font-bold hover:bg-orange-600 transition" onclick="changeQty(${id}, 1)">+</button>
                    </div>
                    <span class="font-black text-orange-600 text-sm w-20 text-right">Rp ${formatRupiah(subtotal)}</span>
                `;
                items.appendChild(row);
            });

            totalEl.textContent = 'Rp ' + formatRupiah(total);
            badge.textContent = count;
        }

        function changeQty(id, delta) {
            if (!cart[id]) return;
            cart[id].qty += delta;
            if (cart[id].qty <= 0) {
                delete cart[id];
            }
            renderCart();
        }

        function formatRupiah(num) {
            return num.toLocaleString('id-ID');
        }

        function showOrderBar() {
            const bar = document.getElementById('order-bar');
            bar.classList.remove('hidden');
        }

        function toggleCart() {
            const body = document.getElementById('cart-body');
            const label = document.getElementById('cart-toggle-label');
            const isHidden = body.classList.contains('hidden');
            body.classList.toggle('hidden');
            label.textContent = isHidden ? 'Sembunyikan' : 'Lihat Detail';
        }

        // ---- WhatsApp send ----
        function sendWhatsApp() {
            const ids = Object.keys(cart);
            if (ids.length === 0) {
                alert('Keranjang masih kosong. Silakan tambahkan menu terlebih dahulu.');
                return;
            }

            const name = document.getElementById('customer-name').value.trim();
            const mode = document.querySelector('input[name="delivery_mode"]:checked').value;
            const address = document.getElementById('customer-address').value.trim();

            if (!name) {
                alert('Mohon isi nama penerima terlebih dahulu.');
                return;
            }

            let lines = [];
            lines.push('*PESANAN DIMSUMYAMIBIT*');
            lines.push('----------------------------------');
            let total = 0;
            ids.forEach(id => {
                const item = cart[id];
                const subtotal = item.harga * item.qty;
                total += subtotal;
                lines.push(`• ${item.nama}`);
                lines.push(`  ${item.qty} x Rp ${formatRupiah(item.harga)} = Rp ${formatRupiah(subtotal)}`);
            });
            lines.push('----------------------------------');
            lines.push(`*TOTAL: Rp ${formatRupiah(total)}*`);
            lines.push('');
            lines.push(`*Nama:* ${name}`);
            lines.push(`*Mode:* ${mode}`);
            if (address) {
                lines.push(`*Alamat:* ${address}`);
            }
            lines.push('');
            lines.push('Terima kasih! Mohon konfirmasi pesanan saya.');

            const message = encodeURIComponent(lines.join('\n'));
            const url = `https://wa.me/${WA_NUMBER}?text=${message}`;
            window.open(url, '_blank');
        }

        // ---- Star rating visual ----
        const starInputs = document.querySelectorAll('.star-input input');
        const starLabels = document.querySelectorAll('.star-input label');
        starInputs.forEach(input => {
            input.addEventListener('change', function () {
                const val = parseInt(this.value);
                starLabels.forEach(label => {
                    const starVal = parseInt(label.dataset.value);
                    if (starVal <= val) {
                        label.classList.add('text-amber-400');
                        label.classList.remove('text-gray-300');
                    } else {
                        label.classList.remove('text-amber-400');
                        label.classList.add('text-gray-300');
                    }
                });
            });
        });
    </script>
</body>
</html>
