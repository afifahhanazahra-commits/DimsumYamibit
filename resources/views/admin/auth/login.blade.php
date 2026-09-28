<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pengelola - Dimsum Yamibit</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-circle.png') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-heading { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-950 via-slate-900 to-rose-950 min-h-screen flex items-center justify-center p-4 antialiased selection:bg-rose-500 selection:text-white">

    <div class="w-full max-w-md space-y-6">
        
        <!-- Brand Header -->
        <div class="text-center space-y-3">
            <img src="{{ asset('images/logo.png') }}" alt="Dimsum Yamibit" class="w-20 h-20 rounded-3xl object-cover mx-auto shadow-2xl shadow-rose-600/40 border-2 border-rose-500/40">
            <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-white tracking-tight">
                Dimsum <span class="text-rose-500">Yamibit</span>
            </h1>
            <p class="text-xs text-slate-400 font-medium uppercase tracking-widest">
                Panel Manajemen & Laporan Keuangan
            </p>
        </div>

        <!-- Login Card -->
        <div class="bg-slate-900/90 border border-slate-800 backdrop-blur-xl rounded-3xl p-8 shadow-2xl text-white space-y-6">
            
            <div class="border-b border-slate-800 pb-4">
                <h2 class="text-lg font-bold font-heading text-white">Masuk Pengelola</h2>
                <p class="text-xs text-slate-400">Gunakan akun admin terdaftar untuk mengontrol operasional toko.</p>
            </div>

            @if($errors->any())
                <div class="bg-rose-500/15 border border-rose-500/40 text-rose-300 text-xs p-3.5 rounded-2xl flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-exclamation text-rose-400 text-base"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('admin.authenticate') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">
                        Alamat Email Admin
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Masukkan email admin" required class="w-full pl-11 pr-4 py-3 bg-slate-950 border border-slate-700 rounded-xl text-sm text-white placeholder-slate-500 focus:border-rose-500 focus:ring-1 focus:ring-rose-500 outline-none transition-all">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1.5">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" name="password" id="password" value="" placeholder="Masukkan kata sandi" required class="w-full pl-11 pr-4 py-3 bg-slate-950 border border-slate-700 rounded-xl text-sm text-white placeholder-slate-500 focus:border-rose-500 focus:ring-1 focus:ring-rose-500 outline-none transition-all">
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 cursor-pointer text-slate-400 hover:text-slate-200">
                        <input type="checkbox" name="remember" class="rounded bg-slate-950 border-slate-700 text-rose-600 focus:ring-rose-500">
                        <span>Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-rose-600 to-rose-700 hover:from-rose-500 hover:to-rose-600 text-white font-bold py-3.5 px-4 rounded-xl text-sm shadow-lg shadow-rose-600/30 transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    <span>Masuk ke Dashboard</span>
                </button>
            </form>

        </div>

        <div class="text-center">
            <a href="{{ route('home') }}" class="text-xs text-slate-400 hover:text-white transition-colors inline-flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Halaman Utama Toko
            </a>
        </div>

    </div>

</body>
</html>
