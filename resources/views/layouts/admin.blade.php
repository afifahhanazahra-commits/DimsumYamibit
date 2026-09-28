<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Dimsum Yamibit</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-circle.png') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        heading: ['"Outfit"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#fff1f2',
                            500: '#f43f5e',
                            600: '#e11d48',
                            700: '#be123c',
                        },
                        dark: {
                            sidebar: '#0f172a',
                            surface: '#1e293b',
                            card: '#334155',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; color: #0f172a; }
        h1, h2, h3, h4, h5, h6, .font-heading { font-family: 'Outfit', sans-serif; }
        
        .btn-gradient {
            background: linear-gradient(135deg, #e11d48 0%, #be123c 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(225, 29, 72, 0.35);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .btn-gradient:hover {
            background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 6px 18px rgba(225, 29, 72, 0.45);
            transform: translateY(-1px);
        }
        .btn-gradient * {
            color: #ffffff !important;
        }
    </style>
    @yield('styles')
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen flex antialiased">

    <!-- Sidebar Navigation -->
    <aside class="w-64 bg-slate-900 text-slate-300 flex-shrink-0 hidden md:flex flex-col border-r border-slate-800">
        <!-- Logo -->
        <div class="h-20 flex items-center gap-3 px-6 bg-slate-950/60 border-b border-slate-800/80">
            <img src="{{ asset('images/logo.png') }}" alt="Dimsum Yamibit" class="w-10 h-10 rounded-xl object-cover shadow-md border border-rose-500/40">
            <div>
                <span class="text-lg font-extrabold font-heading text-white tracking-tight block">Dimsum Yamibit</span>
                <span class="text-[10px] uppercase tracking-widest text-amber-400 font-bold block">Panel Pengelola</span>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold text-sm transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-rose-600 text-white shadow-md shadow-rose-600/30 font-bold' : 'hover:bg-slate-800 hover:text-white text-slate-400' }}">
                <i class="fa-solid fa-chart-pie w-5 text-center"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.pesanan.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-semibold text-sm transition-all {{ request()->routeIs('admin.pesanan.*') ? 'bg-rose-600 text-white shadow-md shadow-rose-600/30 font-bold' : 'hover:bg-slate-800 hover:text-white text-slate-400' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-receipt w-5 text-center"></i>
                    <span>Pesanan & QRIS</span>
                </div>
                @php
                    $pendingCount = \App\Models\Pesanan::where('status_pembayaran', 'menunggu')->count();
                @endphp
                @if($pendingCount > 0)
                    <span class="bg-amber-500 text-white text-[11px] font-extrabold px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>
                @endif
            </a>

            <div class="pt-4 pb-1 px-3 text-[10px] font-extrabold tracking-wider uppercase text-slate-500">
                Master Data Menu & Stok
            </div>

            <a href="{{ route('admin.menu.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold text-sm transition-all {{ request()->routeIs('admin.menu.*') ? 'bg-rose-600 text-white shadow-md shadow-rose-600/30 font-bold' : 'hover:bg-slate-800 hover:text-white text-slate-400' }}">
                <i class="fa-solid fa-utensils w-5 text-center"></i>
                <span>Katalog Menu</span>
            </a>

            <a href="{{ route('admin.topping.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold text-sm transition-all {{ request()->routeIs('admin.topping.*') ? 'bg-rose-600 text-white shadow-md shadow-rose-600/30 font-bold' : 'hover:bg-slate-800 hover:text-white text-slate-400' }}">
                <i class="fa-solid fa-pepper-hot w-5 text-center"></i>
                <span>Topping & Saus</span>
            </a>

            <a href="{{ route('admin.stok.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-semibold text-sm transition-all {{ request()->routeIs('admin.stok.*') ? 'bg-rose-600 text-white shadow-md shadow-rose-600/30 font-bold' : 'hover:bg-slate-800 hover:text-white text-slate-400' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-boxes-stacked w-5 text-center"></i>
                    <span>Stok Real-Time</span>
                </div>
                @php
                    $lowStockCount = \App\Models\Stok::where('jumlah_stok', '<=', 10)->count();
                @endphp
                @if($lowStockCount > 0)
                    <span class="bg-rose-500 text-white text-[11px] font-extrabold px-2 py-0.5 rounded-full">{{ $lowStockCount }}</span>
                @endif
            </a>

            <div class="pt-4 pb-1 px-3 text-[10px] font-extrabold tracking-wider uppercase text-slate-500">
                Laporan & Pelaporan
            </div>

            <a href="{{ route('admin.laporan.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold text-sm transition-all {{ request()->routeIs('admin.laporan.*') ? 'bg-rose-600 text-white shadow-md shadow-rose-600/30 font-bold' : 'hover:bg-slate-800 hover:text-white text-slate-400' }}">
                <i class="fa-solid fa-file-invoice-dollar w-5 text-center"></i>
                <span>Laporan Keuangan</span>
            </a>

            <div class="pt-4 pb-1 px-3 text-[10px] font-extrabold tracking-wider uppercase text-slate-500">
                Sistem & Pengaturan
            </div>

            <a href="{{ route('admin.pengaturan.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-semibold text-sm transition-all {{ request()->routeIs('admin.pengaturan.*') ? 'bg-rose-600 text-white shadow-md shadow-rose-600/30 font-bold' : 'hover:bg-slate-800 hover:text-white text-slate-400' }}">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-store w-5 text-center"></i>
                    <span>Buka / Tutup Toko</span>
                </div>
                @php
                    $navStoreStatus = \App\Services\StoreSchedule::getStatus();
                @endphp
                <span class="text-[10px] font-extrabold px-2 py-0.5 rounded-full {{ $navStoreStatus['is_open'] ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : 'bg-rose-500/20 text-rose-400 border border-rose-500/30' }}">
                    {{ $navStoreStatus['is_open'] ? 'Buka' : 'Tutup' }}
                </span>
            </a>
        </nav>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-slate-800/80 bg-slate-950/40">
            <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-center gap-2 w-full py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-bold transition-colors">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>Lihat Web Toko</span>
            </a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0">
        
        <!-- Topbar -->
        <header class="h-20 bg-white border-b border-slate-200 px-4 sm:px-8 flex items-center justify-between sticky top-0 z-30 shadow-sm">
            <div class="flex items-center gap-3">
                <!-- Mobile Toggle -->
                <button type="button" onclick="document.getElementById('mobile-sidebar').classList.toggle('hidden')" class="md:hidden text-slate-600 p-2 rounded-lg hover:bg-slate-100">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h1 class="text-xl font-extrabold font-heading text-slate-900">
                    @yield('header_title', 'Dashboard')
                </h1>
            </div>

            <!-- Store Status & Profile -->
            <div class="flex items-center gap-3 sm:gap-4">
                @php
                    $topStoreStatus = \App\Services\StoreSchedule::getStatus();
                @endphp
                <a href="{{ route('admin.pengaturan.index') }}" class="px-3 py-1.5 rounded-xl text-xs font-extrabold border flex items-center gap-2 transition-all hover:shadow-sm {{ $topStoreStatus['is_open'] ? 'bg-emerald-50 text-emerald-800 border-emerald-200 hover:bg-emerald-100' : 'bg-rose-50 text-rose-800 border-rose-200 hover:bg-rose-100' }}" title="Klik untuk ubah pengaturan buka/tutup toko">
                    <span class="w-2 h-2 rounded-full {{ $topStoreStatus['is_open'] ? 'bg-emerald-500 animate-pulse' : 'bg-rose-500' }}"></span>
                    <span class="hidden sm:inline">Toko:</span>
                    <span>{{ $topStoreStatus['is_open'] ? 'Buka' : 'Tutup' }}</span>
                    <i class="fa-solid fa-gear text-[10px] text-slate-400"></i>
                </a>

                <div class="hidden sm:flex flex-col text-right">
                    <span class="text-xs font-extrabold text-slate-900">{{ Auth::user()->name ?? 'Admin Yamibit' }}</span>
                    <span class="text-[11px] text-slate-500">Pengelola Usaha</span>
                </div>

                <div class="w-10 h-10 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center font-bold font-heading text-sm border border-rose-200">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>

                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin logout?')" class="bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-600 p-2.5 rounded-xl text-sm transition-colors" title="Keluar">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </header>

        <!-- Mobile Sidebar Modal -->
        <div id="mobile-sidebar" class="hidden md:hidden fixed inset-0 z-50 bg-black/60">
            <div class="w-64 bg-slate-900 text-slate-300 h-full flex flex-col p-4">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center gap-2.5">
                        <img src="{{ asset('images/logo.png') }}" alt="Dimsum Yamibit" class="w-7 h-7 rounded-lg object-cover">
                        <span class="font-bold text-white text-sm">Dimsum Yamibit</span>
                    </div>
                    <button onclick="document.getElementById('mobile-sidebar').classList.add('hidden')" class="text-white">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>
                <nav class="space-y-2 text-sm font-semibold">
                    <a href="{{ route('admin.dashboard') }}" class="block p-2 rounded hover:bg-slate-800">Dashboard</a>
                    <a href="{{ route('admin.pesanan.index') }}" class="block p-2 rounded hover:bg-slate-800">Pesanan Masuk</a>
                    <a href="{{ route('admin.menu.index') }}" class="block p-2 rounded hover:bg-slate-800">Katalog Menu</a>
                    <a href="{{ route('admin.topping.index') }}" class="block p-2 rounded hover:bg-slate-800">Topping & Saus</a>
                    <a href="{{ route('admin.stok.index') }}" class="block p-2 rounded hover:bg-slate-800">Stok Real-Time</a>
                    <a href="{{ route('admin.laporan.index') }}" class="block p-2 rounded hover:bg-slate-800">Laporan Keuangan</a>
                    <a href="{{ route('admin.pengaturan.index') }}" class="block p-2 rounded hover:bg-slate-800 text-rose-400 font-bold">Buka / Tutup Toko</a>
                </nav>
            </div>
        </div>

        <!-- Page Alerts -->
        @if(session('success'))
            <div class="px-4 sm:px-8 mt-6">
                <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-xl shadow-sm text-emerald-900 flex items-center justify-between text-sm">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-600"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="px-4 sm:px-8 mt-6">
                <div class="bg-rose-50 border-l-4 border-rose-500 p-4 rounded-xl shadow-sm text-rose-900 flex items-center justify-between text-sm">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Workspace -->
        <main class="flex-1 p-4 sm:p-8">
            @yield('content')
        </main>

    </div>

    @yield('scripts')
</body>
</html>
