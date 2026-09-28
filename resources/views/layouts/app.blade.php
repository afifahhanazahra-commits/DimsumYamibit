<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dimsum Yamibit - Cita Rasa Dimsum Premium & Gurih')</title>
    <meta name="description" content="Sistem Pemesanan Online Dimsum Yamibit Cirebon. Nikmati aneka varian dimsum mentai, original, gyoza, dan bola ayam keju berkualitas tinggi.">
    
    <!-- Google Fonts: Plus Jakarta Sans & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-circle.png') }}">

    <!-- Tailwind CSS CDN for instant robust styling & custom design tokens -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        heading: ['"Outfit"', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#fff1f2',
                            100: '#ffe4e6',
                            200: '#fecdd3',
                            500: '#f43f5e',
                            600: '#e11d48',
                            700: '#be123c',
                            800: '#9f1239',
                            900: '#881337',
                        },
                        amber: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            500: '#f59e0b',
                            600: '#d97706',
                            700: '#b45309',
                        },
                        dimsum: {
                            dark: '#141416',
                            card: '#1e1e24',
                            cream: '#fcf9f2',
                            accent: '#ff5e3a',
                            gold: '#ffb703',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #faf9f6;
            color: #1f2937;
        }
        h1, h2, h3, h4, h5, h6, .font-heading {
            font-family: 'Outfit', sans-serif;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
        .glass-dark {
            background: rgba(20, 20, 22, 0.88);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .btn-gradient {
            background: linear-gradient(135deg, #e11d48 0%, #ff5e3a 100%);
            box-shadow: 0 4px 15px rgba(225, 29, 72, 0.35);
            transition: all 0.25s ease;
        }
        .btn-gradient:hover {
            background: linear-gradient(135deg, #be123c 0%, #ea580c 100%);
            box-shadow: 0 6px 20px rgba(225, 29, 72, 0.45);
            transform: translateY(-1px);
        }
        .badge-pulse {
            animation: pulse-glow 2s infinite;
        }
        @keyframes pulse-glow {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.85; transform: scale(1.03); }
        }
    </style>
    @yield('styles')
</head>
<body class="min-h-screen flex flex-col antialiased selection:bg-rose-500 selection:text-white">

    @php
        $storeSchedule = \App\Services\StoreSchedule::getStatus();
    @endphp

    <!-- Top Announcement Bar -->
    @if(!$storeSchedule['is_open'])
        <div class="bg-gradient-to-r from-rose-900 via-rose-800 to-amber-800 text-white text-xs py-2.5 px-4 text-center font-bold flex flex-wrap items-center justify-center gap-2 shadow-sm border-b border-rose-950">
            <span class="bg-rose-950/80 text-rose-200 border border-rose-400/50 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold flex items-center gap-1.5 uppercase tracking-wider">
                <i class="fa-solid {{ $storeSchedule['badge_icon'] }} text-amber-400"></i> {{ $storeSchedule['status_label'] }}
            </span>
            <span class="text-xs font-semibold">⚠️ {{ $storeSchedule['message'] }}</span>
        </div>
    @else
        <div class="bg-gradient-to-r from-emerald-800 via-emerald-700 to-teal-800 text-white text-xs py-2 px-4 text-center font-medium flex flex-wrap items-center justify-center gap-2 shadow-sm">
            <span class="bg-emerald-950/80 text-emerald-200 border border-emerald-400/50 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold flex items-center gap-1 uppercase tracking-wider">
                <i class="fa-solid fa-circle-check text-emerald-300"></i> BUKA SEKARANG
            </span>
            <span class="text-xs">🥟 Jam Buka: 14.30 - 21.00 WIB (Selasa - Minggu) • Pengiriman via Pickup & Ojek Online Mandiri</span>
        </div>
    @endif

    <!-- Main Navigation Bar -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-rose-100 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo & Brand -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/logo-circle.png') }}" alt="Dimsum Yamibit" class="w-12 h-12 rounded-full object-cover shadow-md border-2 border-rose-500 group-hover:scale-105 transition-transform bg-white">
                    <div>
                        <span class="text-2xl font-extrabold font-heading tracking-tight text-gray-900 flex items-center gap-1">
                            Dimsum <span class="text-rose-600">Yamibit</span>
                        </span>
                        <div class="flex items-center gap-2 -mt-0.5">
                            @if($storeSchedule['is_open'])
                                <span class="text-[10px] font-extrabold text-emerald-600 uppercase tracking-wider flex items-center gap-1">
                                    <i class="fa-solid fa-circle text-[6px]"></i> Buka Sekarang
                                </span>
                            @else
                                <span class="text-[10px] font-extrabold text-rose-600 uppercase tracking-wider flex items-center gap-1">
                                    <i class="fa-solid fa-lock text-[8px]"></i> Toko Tutup (14.30-21.00)
                                </span>
                            @endif
                            <span class="text-[10px] text-gray-400 font-medium hidden sm:inline">• Talun, Cirebon</span>
                        </div>
                    </div>
                </a>

                <!-- Nav Links & Quick Actions -->
                <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-gray-700">
                    <a href="{{ route('home') }}#menu" class="hover:text-rose-600 transition-colors flex items-center gap-1.5">
                        <i class="fa-solid fa-utensils text-rose-500 text-xs"></i>
                        Katalog Menu
                    </a>
                    <a href="{{ route('home') }}#tentang" class="hover:text-rose-600 transition-colors flex items-center gap-1.5">
                        <i class="fa-solid fa-heart text-rose-500 text-xs"></i>
                        Tentang Kami
                    </a>
                    <a href="{{ route('home') }}#lokasi" class="hover:text-rose-600 transition-colors flex items-center gap-1.5">
                        <i class="fa-solid fa-location-dot text-rose-500 text-xs"></i>
                        Lokasi & Kontak
                    </a>
                </nav>

                <!-- Right Action Buttons -->
                <div class="flex items-center gap-3">
                    <!-- Cart Button Trigger -->
                    <button type="button" onclick="openCartModal()" class="relative bg-rose-50 hover:bg-rose-100 text-rose-700 px-4 py-2.5 rounded-xl font-bold text-sm flex items-center gap-2 border border-rose-200 transition-all shadow-sm">
                        <i class="fa-solid fa-basket-shopping text-base text-rose-600"></i>
                        <span class="hidden sm:inline">Keranjang</span>
                        <span id="cart-badge-count" class="bg-rose-600 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center font-extrabold shadow-sm">0</span>
                    </button>

                    <!-- Admin Portal Link -->
                    <a href="{{ route('admin.login') }}" class="text-xs text-gray-500 hover:text-rose-600 px-2.5 py-2 rounded-lg border border-gray-200 hover:border-rose-300 transition-colors flex items-center gap-1.5">
                        <i class="fa-solid fa-user-shield"></i>
                        <span class="hidden lg:inline">Admin</span>
                    </a>
                </div>

            </div>
        </div>
    </header>

    <!-- Flash Messages (Toast Alerts) -->
    @if(session('success'))
        <div id="flash-success" class="max-w-4xl mx-auto px-4 mt-4 w-full">
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-xl shadow-md flex items-center justify-between gap-3 text-emerald-900">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-xl"></i>
                    <div>
                        <p class="font-bold text-sm">Berhasil!</p>
                        <p class="text-xs text-emerald-700">{{ session('success') }}</p>
                    </div>
                </div>
                <button onclick="document.getElementById('flash-success').remove()" class="text-emerald-500 hover:text-emerald-800 text-sm">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div id="flash-error" class="max-w-4xl mx-auto px-4 mt-4 w-full">
            <div class="bg-rose-50 border-l-4 border-rose-500 p-4 rounded-xl shadow-md flex items-center justify-between gap-3 text-rose-900">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 text-xl"></i>
                    <div>
                        <p class="font-bold text-sm">Perhatian!</p>
                        <p class="text-xs text-rose-700">{{ session('error') }}</p>
                    </div>
                </div>
                <button onclick="document.getElementById('flash-error').remove()" class="text-rose-500 hover:text-rose-800 text-sm">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Floating WhatsApp Action (Desktop) -->
    <a href="https://api.whatsapp.com/send?phone=628990745953&text=Halo%20Dimsum%20Yamibit,%20saya%20ingin%20bertanya%20seputar%20menu%20dan%20pemesanan." target="_blank" class="hidden sm:flex fixed bottom-6 right-6 z-40 bg-emerald-500 hover:bg-emerald-600 text-white p-4 rounded-full shadow-2xl items-center justify-center gap-2 group transition-all duration-300 hover:scale-110">
        <i class="fa-brands fa-whatsapp text-2xl"></i>
        <span class="max-w-0 overflow-hidden whitespace-nowrap group-hover:max-w-xs transition-all duration-300 ease-in-out font-bold text-sm pr-1">Chat WhatsApp</span>
    </a>

    <!-- Sticky Mobile Bottom App Navigation Bar -->
    <div class="sm:hidden fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-t border-rose-100 shadow-[0_-4px_20px_rgba(0,0,0,0.08)] px-4 py-2 flex items-center justify-around text-xs">
        <a href="{{ route('home') }}#menu" class="flex flex-col items-center gap-1 text-slate-600 hover:text-rose-600 font-bold">
            <i class="fa-solid fa-utensils text-base text-rose-500"></i>
            <span class="text-[10px]">Menu</span>
        </a>

        <button type="button" onclick="openCartModal()" class="relative flex flex-col items-center gap-1 text-rose-600 font-extrabold">
            <div class="relative">
                <i class="fa-solid fa-basket-shopping text-xl"></i>
                <span id="mobile-cart-badge" class="absolute -top-1 -right-2.5 bg-rose-600 text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold shadow">0</span>
            </div>
            <span class="text-[10px]">Keranjang</span>
        </button>

        <a href="https://wa.me/628990745953" target="_blank" class="flex flex-col items-center gap-1 text-emerald-600 font-bold">
            <i class="fa-brands fa-whatsapp text-xl"></i>
            <span class="text-[10px]">WhatsApp</span>
        </a>

        <a href="{{ route('admin.login') }}" class="flex flex-col items-center gap-1 text-slate-400 hover:text-slate-700 font-medium">
            <i class="fa-solid fa-user-shield text-base"></i>
            <span class="text-[10px]">Admin</span>
        </a>
    </div>

    <!-- Footer -->
    <footer class="bg-dimsum-dark text-gray-300 pt-16 pb-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                
                <!-- Col 1: Brand & Bio -->
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo-circle.png') }}" alt="Dimsum Yamibit" class="w-11 h-11 rounded-full object-cover shadow-md border-2 border-rose-500 bg-white">
                        <span class="text-2xl font-extrabold font-heading text-white">
                            Dimsum <span class="text-rose-500">Yamibit</span>
                        </span>
                    </div>
                    <p class="text-sm text-gray-400 leading-relaxed max-w-md">
                        Dimsum Yamibit adalah usaha kuliner olahan daging ayam dan udang segar berkualitas tinggi. Menyajikan sensasi dimsum premium dengan tekstur lembut, gurih, dan aneka varian saus lezat tanpa bahan pengawet.
                    </p>
                </div>

                <!-- Col 2: Jam & Layanan -->
                <div>
                    <h4 class="text-white font-heading font-bold text-base mb-4 border-l-4 border-rose-500 pl-3">
                        Jam & Pemesanan
                    </h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li class="flex items-center gap-2 font-bold text-rose-400"><i class="fa-regular fa-clock"></i> Selasa - Minggu</li>
                        <li class="font-medium text-gray-200">14.30 - 21.00 WIB</li>
                        <li class="text-xs text-rose-300 font-semibold">(Hari Senin Tutup / Libur)</li>
                        <li class="pt-2 text-xs text-gray-400">
                            🛵 <strong>Metode Ambil:</strong><br>
                            - Pickup (Ambil di Outlet)<br>
                            - Pesan Ojek Online Mandiri
                        </li>
                    </ul>
                </div>

                <!-- Col 3: Lokasi & Kontak -->
                <div>
                    <h4 class="text-white font-heading font-bold text-base mb-4 border-l-4 border-rose-500 pl-3">
                        Lokasi Outlet
                    </h4>
                    <p class="text-xs text-gray-400 leading-relaxed mb-3">
                        <i class="fa-solid fa-location-dot text-rose-500 mr-1"></i>
                        Arumsari, Jl. Jembatan Merah No.02, Kecomberan, Kec. Talun, Kabupaten Cirebon, Jawa Barat 45171
                    </p>
                    <a href="https://wa.me/628990745953" target="_blank" class="inline-flex items-center gap-2 text-sm text-emerald-400 hover:text-emerald-300 font-semibold">
                        <i class="fa-brands fa-whatsapp text-lg"></i>
                        08990745953
                    </a>
                </div>

            </div>

            <div class="mt-12 pt-6 border-t border-gray-800 text-center text-xs text-gray-500 flex flex-col sm:flex-row items-center justify-between gap-3">
                <p>&copy; {{ date('Y') }} Dimsum Yamibit. All rights reserved.</p>
                <p>Platform Pemesanan Online Dimsum Yamibit Cirebon</p>
            </div>
        </div>
    </footer>

    <!-- Cart Drawer / Slide-Over Modal -->
    <div id="cart-drawer" class="fixed inset-0 z-50 hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeCartModal()"></div>

        <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
            <div class="w-screen max-w-md bg-white shadow-2xl flex flex-col">
                
                <!-- Drawer Header -->
                <div class="p-5 bg-gradient-to-r from-rose-600 to-rose-700 text-white flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-basket-shopping text-2xl"></i>
                        <div>
                            <h3 class="font-heading font-bold text-lg leading-tight">Keranjang Pesanan</h3>
                            <p class="text-xs text-rose-100">Dimsum Yamibit Cirebon</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeCartModal()" class="text-white hover:text-rose-200 p-1.5 rounded-lg hover:bg-white/10 text-lg">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Cart Items Container -->
                <div id="cart-items-list" class="flex-1 overflow-y-auto p-5 space-y-4">
                    <!-- Populated dynamically via JavaScript -->
                </div>

                <!-- Drawer Footer (Subtotal & Checkout Button) -->
                <div class="border-t border-gray-200 p-5 bg-gray-50 space-y-4">
                    <div class="space-y-1.5">
                        <div class="flex justify-between text-xs text-gray-500 font-medium">
                            <span>Total Porsi</span>
                            <span id="cart-total-qty">0 porsi</span>
                        </div>
                        <div class="flex justify-between text-base font-extrabold text-gray-900">
                            <span>Total Pembayaran</span>
                            <span id="cart-total-price" class="text-rose-600 font-heading text-xl">Rp 0</span>
                        </div>
                    </div>

                    @if(!$storeSchedule['is_open'])
                        <div class="p-3 bg-rose-50 border border-rose-200 rounded-xl text-xs text-rose-800 space-y-1">
                            <p class="font-bold flex items-center gap-1.5 text-rose-700">
                                <i class="fa-solid fa-lock"></i> Toko Sedang Tutup
                            </p>
                            <p class="text-[11px] leading-relaxed">
                                Mohon maaf, checkout belum dapat diproses. Jam buka: <strong>Selasa - Minggu, 14.30 - 21.00 WIB</strong> (Senin Libur).
                            </p>
                        </div>
                        <button type="button" disabled class="w-full bg-slate-300 text-slate-500 py-3.5 px-4 rounded-xl font-bold text-sm text-center block cursor-not-allowed flex items-center justify-center gap-2">
                            <i class="fa-solid fa-lock"></i>
                            <span>Pemesanan Ditutup (Buka 14.30 WIB)</span>
                        </button>
                    @else
                        <a href="{{ route('checkout') }}" id="btn-proceed-checkout" class="w-full btn-gradient text-white py-3.5 px-4 rounded-xl font-bold text-sm text-center block shadow-lg flex items-center justify-center gap-2">
                            <span>Lanjut ke Pembayaran QRIS</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <!-- Universal Cart Logic in LocalStorage -->
    <script>
        const CART_STORAGE_KEY = 'yamibit_cart_v1';

        function getCart() {
            try {
                return JSON.parse(localStorage.getItem(CART_STORAGE_KEY)) || [];
            } catch (e) {
                return [];
            }
        }

        function saveCart(cart) {
            localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(cart));
            updateCartBadge();
            renderCartDrawer();
        }

        function updateCartBadge() {
            const cart = getCart();
            const totalCount = cart.reduce((sum, item) => sum + (parseInt(item.qty) || 1), 0);
            const badge = document.getElementById('cart-badge-count');
            if (badge) {
                badge.innerText = totalCount;
            }
            const mobileBadge = document.getElementById('mobile-cart-badge');
            if (mobileBadge) {
                mobileBadge.innerText = totalCount;
            }
        }

        function openCartModal() {
            renderCartDrawer();
            document.getElementById('cart-drawer').classList.remove('hidden');
        }

        function closeCartModal() {
            document.getElementById('cart-drawer').classList.add('hidden');
        }

        function renderCartDrawer() {
            const cart = getCart();
            const container = document.getElementById('cart-items-list');
            const totalQtyEl = document.getElementById('cart-total-qty');
            const totalPriceEl = document.getElementById('cart-total-price');
            const checkoutBtn = document.getElementById('btn-proceed-checkout');

            if (!container) return;

            if (cart.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-16 px-4 text-gray-400">
                        <div class="w-16 h-16 rounded-full bg-rose-50 text-rose-400 flex items-center justify-center mx-auto mb-3 text-2xl">
                            <i class="fa-solid fa-basket-shopping"></i>
                        </div>
                        <p class="font-bold text-gray-700 text-sm">Keranjang Anda Masih Kosong</p>
                        <p class="text-xs text-gray-400 mt-1">Pilih menu dimsum lezat kami dan tambahkan ke keranjang.</p>
                        <button onclick="closeCartModal()" class="mt-4 px-4 py-2 bg-rose-600 text-white rounded-lg text-xs font-bold hover:bg-rose-700">
                            Lihat Menu Sekarang
                        </button>
                    </div>
                `;
                totalQtyEl.innerText = '0 porsi';
                totalPriceEl.innerText = 'Rp 0';
                if (checkoutBtn) checkoutBtn.classList.add('opacity-50', 'pointer-events-none');
                return;
            }

            if (checkoutBtn) checkoutBtn.classList.remove('opacity-50', 'pointer-events-none');

            let totalQty = 0;
            let totalPrice = 0;
            let html = '';

            cart.forEach((item, index) => {
                const itemPrice = parseInt(item.price) + (parseInt(item.toppingPrice) || 0);
                const subtotal = itemPrice * item.qty;
                totalQty += item.qty;
                totalPrice += subtotal;

                html += `
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-3 flex gap-3 items-center relative">
                        <div class="w-14 h-14 rounded-xl bg-stone-950 flex-shrink-0 flex items-center justify-center text-rose-500 overflow-hidden p-1 border border-stone-800 shadow-inner">
                            ${item.foto ? `<img src="${item.foto}" class="w-full h-full object-contain" alt="${item.name}">` : `<i class="fa-solid fa-bowl-food text-xl text-rose-400"></i>`}
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-sm text-gray-900 truncate">${item.name}</h4>
                            <p class="text-xs text-rose-600 font-semibold">
                                ${item.toppingName ? `<i class="fa-solid fa-plus text-[10px]"></i> Topping: ${item.toppingName}` : 'Varian Original'}
                            </p>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-xs font-bold text-gray-800">Rp ${subtotal.toLocaleString('id-ID')}</span>
                                
                                <div class="flex items-center border border-gray-300 rounded-lg bg-white">
                                    <button type="button" onclick="changeCartQty(${index}, -1)" class="w-6 h-6 flex items-center justify-center text-gray-600 hover:bg-gray-100 text-xs rounded-l-lg">-</button>
                                    <span class="w-7 text-center text-xs font-bold text-gray-800">${item.qty}</span>
                                    <button type="button" onclick="changeCartQty(${index}, 1)" class="w-6 h-6 flex items-center justify-center text-gray-600 hover:bg-gray-100 text-xs rounded-r-lg">+</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" onclick="removeCartItem(${index})" class="text-gray-400 hover:text-rose-600 p-1 text-xs self-start">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                `;
            });

            container.innerHTML = html;
            totalQtyEl.innerText = `${totalQty} porsi`;
            totalPriceEl.innerText = `Rp ${totalPrice.toLocaleString('id-ID')}`;
        }

        function changeCartQty(index, delta) {
            const cart = getCart();
            if (cart[index]) {
                cart[index].qty += delta;
                if (cart[index].qty <= 0) {
                    cart.splice(index, 1);
                }
                saveCart(cart);
            }
        }

        function removeCartItem(index) {
            const cart = getCart();
            cart.splice(index, 1);
            saveCart(cart);
        }

        // Initialize on DOM load
        document.addEventListener('DOMContentLoaded', () => {
            updateCartBadge();
        });
    </script>

    @yield('scripts')
</body>
</html>
