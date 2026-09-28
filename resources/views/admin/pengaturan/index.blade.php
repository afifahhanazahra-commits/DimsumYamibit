@extends('layouts.admin')

@section('title', 'Pengaturan Buka / Tutup Toko')
@section('header_title', 'Pengaturan Operasional Toko')

@section('content')
<div class="space-y-8 max-w-5xl">

    <!-- Status Saat Ini Card & Quick Action -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Live Status Toko Saat Ini</span>
                <div class="flex items-center gap-3 mt-1">
                    <h2 class="text-2xl font-extrabold font-heading text-slate-900">
                        {{ $status['status_label'] }}
                    </h2>
                    <span class="px-3 py-1 rounded-xl text-xs font-extrabold flex items-center gap-1.5 {{ $status['is_open'] ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-rose-100 text-rose-800 border border-rose-200' }}">
                        <i class="fa-solid {{ $status['badge_icon'] }}"></i>
                        {{ $status['is_open'] ? 'Menerima Pesanan' : 'Pemesanan Dinonaktifkan' }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">
                    Waktu Sistem: <strong>{{ $status['current_time'] }}</strong> • Jadwal Default: {{ $settings['open_time'] }} - {{ $settings['close_time'] }} WIB
                </p>
            </div>

            <!-- Quick Action 1-Click Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                <!-- Buka Paksa -->
                <form action="{{ route('admin.pengaturan.quickToggle') }}" method="POST">
                    @csrf
                    <input type="hidden" name="mode" value="open">
                    <button type="submit" class="px-4 py-2.5 rounded-xl text-xs font-bold flex items-center gap-2 shadow-sm transition-all {{ $settings['mode'] === 'open' ? 'bg-emerald-600 text-white shadow-emerald-500/30' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200' }}">
                        <i class="fa-solid fa-door-open"></i>
                        <span>Paksa Buka</span>
                    </button>
                </form>

                <!-- Tutup Paksa -->
                <form action="{{ route('admin.pengaturan.quickToggle') }}" method="POST">
                    @csrf
                    <input type="hidden" name="mode" value="closed">
                    <button type="submit" class="px-4 py-2.5 rounded-xl text-xs font-bold flex items-center gap-2 shadow-sm transition-all {{ $settings['mode'] === 'closed' ? 'bg-rose-600 text-white shadow-rose-500/30' : 'bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200' }}">
                        <i class="fa-solid fa-lock"></i>
                        <span>Tutup Sementara</span>
                    </button>
                </form>

                <!-- Mode Otomatis -->
                <form action="{{ route('admin.pengaturan.quickToggle') }}" method="POST">
                    @csrf
                    <input type="hidden" name="mode" value="auto">
                    <button type="submit" class="px-4 py-2.5 rounded-xl text-xs font-bold flex items-center gap-2 shadow-sm transition-all {{ $settings['mode'] === 'auto' ? 'bg-slate-900 text-white shadow-slate-900/30' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 border border-slate-300' }}">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        <span>Otomatis (Jadwal)</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Penjelasan Status Aktif -->
        <div class="p-4 rounded-2xl {{ $status['is_open'] ? 'bg-emerald-50/70 border border-emerald-200 text-emerald-900' : 'bg-amber-50/70 border border-amber-200 text-amber-900' }} text-xs space-y-1">
            <div class="font-bold flex items-center gap-2">
                <i class="fa-solid fa-circle-info"></i>
                <span>Status Aktif Saat Ini:</span>
            </div>
            <p>{{ $status['message'] }}</p>
            @if($status['next_open'])
                <p class="text-[11px] font-semibold text-slate-600 pt-0.5">
                    ℹ️ Rencana Buka Kembali: <strong>{{ $status['next_open'] }}</strong>
                </p>
            @endif
        </div>
    </div>

    <!-- Main Settings Form -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
        <div class="border-b border-slate-100 pb-4">
            <h3 class="font-bold font-heading text-slate-900 text-base">Konfigurasi Jadwal & Mode Toko</h3>
            <p class="text-xs text-slate-400">Atur jam buka, jam tutup harian, hari libur mingguan, dan pesan pemberitahuan pelanggan.</p>
        </div>

        <form action="{{ route('admin.pengaturan.update') }}" method="POST" class="space-y-6">
            @csrf

            <!-- 1. Mode Operasional -->
            <div class="space-y-3">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                    Mode Pengoperasian Toko <span class="text-rose-600">*</span>
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    
                    <!-- Auto -->
                    <label class="relative flex flex-col p-4 border-2 rounded-2xl cursor-pointer transition-all {{ $settings['mode'] === 'auto' ? 'border-slate-900 bg-slate-50' : 'border-slate-200 hover:border-slate-300' }}">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-bold text-sm text-slate-900 flex items-center gap-2">
                                <i class="fa-solid fa-clock text-slate-700"></i> Otomatis
                            </span>
                            <input type="radio" name="mode" value="auto" {{ $settings['mode'] === 'auto' ? 'checked' : '' }} class="text-slate-900 focus:ring-slate-900">
                        </div>
                        <p class="text-[11px] text-slate-500">
                            Buka & tutup otomatis membaca jam WIB dan hari libur mingguan yang disetel.
                        </p>
                    </label>

                    <!-- Manual Open -->
                    <label class="relative flex flex-col p-4 border-2 rounded-2xl cursor-pointer transition-all {{ $settings['mode'] === 'open' ? 'border-emerald-600 bg-emerald-50/40' : 'border-slate-200 hover:border-emerald-300' }}">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-bold text-sm text-emerald-800 flex items-center gap-2">
                                <i class="fa-solid fa-door-open text-emerald-600"></i> Buka Terus
                            </span>
                            <input type="radio" name="mode" value="open" {{ $settings['mode'] === 'open' ? 'checked' : '' }} class="text-emerald-600 focus:ring-emerald-600">
                        </div>
                        <p class="text-[11px] text-slate-500">
                            Paksa toko selalu buka dan menerima checkout pesanan kapan saja.
                        </p>
                    </label>

                    <!-- Manual Closed -->
                    <label class="relative flex flex-col p-4 border-2 rounded-2xl cursor-pointer transition-all {{ $settings['mode'] === 'closed' ? 'border-rose-600 bg-rose-50/40' : 'border-slate-200 hover:border-rose-300' }}">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-bold text-sm text-rose-800 flex items-center gap-2">
                                <i class="fa-solid fa-lock text-rose-600"></i> Tutup Sementara
                            </span>
                            <input type="radio" name="mode" value="closed" {{ $settings['mode'] === 'closed' ? 'checked' : '' }} class="text-rose-600 focus:ring-rose-600">
                        </div>
                        <p class="text-[11px] text-slate-500">
                            Kunci formulir checkout sementara (misal: stok habis, istirahat mendadak).
                        </p>
                    </label>

                </div>
            </div>

            <!-- 2. Jam Operasional Harian -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2">
                <div>
                    <label for="open_time" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Jam Buka Toko (WIB) <span class="text-rose-600">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="fa-regular fa-clock"></i>
                        </span>
                        <input type="text" name="open_time" id="open_time" value="{{ old('open_time', $settings['open_time']) }}" placeholder="14:30" required pattern="[0-2][0-9]:[0-5][0-9]" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm font-bold text-slate-900 focus:ring-2 focus:ring-rose-500 outline-none">
                    </div>
                    <span class="text-[11px] text-slate-400 mt-1 block">Format 24 Jam (Contoh: 14:30)</span>
                </div>

                <div>
                    <label for="close_time" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Jam Tutup Toko (WIB) <span class="text-rose-600">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="fa-regular fa-clock"></i>
                        </span>
                        <input type="text" name="close_time" id="close_time" value="{{ old('close_time', $settings['close_time']) }}" placeholder="21:00" required pattern="[0-2][0-9]:[0-5][0-9]" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm font-bold text-slate-900 focus:ring-2 focus:ring-rose-500 outline-none">
                    </div>
                    <span class="text-[11px] text-slate-400 mt-1 block">Format 24 Jam (Contoh: 21:00)</span>
                </div>
            </div>

            <!-- 3. Hari Libur Mingguan -->
            <div class="space-y-2 pt-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                    Hari Libur Rutin (Toko Tutup Seharian)
                </label>
                <p class="text-xs text-slate-400">Centang hari-hari saat toko Dimsum Yamibit libur / tidak beroperasi.</p>
                
                @php
                    $daysList = [
                        1 => 'Senin',
                        2 => 'Selasa',
                        3 => 'Rabu',
                        4 => 'Kamis',
                        5 => 'Jumat',
                        6 => 'Sabtu',
                        7 => 'Minggu'
                    ];
                    $currentClosedDays = $settings['closed_days'] ?? [1];
                @endphp

                <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-7 gap-2.5 pt-1">
                    @foreach($daysList as $num => $dayName)
                        <label class="flex items-center gap-2 p-3 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl cursor-pointer transition-colors text-xs font-bold text-slate-800">
                            <input type="checkbox" name="closed_days[]" value="{{ $num }}" {{ in_array($num, $currentClosedDays) ? 'checked' : '' }} class="rounded border-slate-300 text-rose-600 focus:ring-rose-500">
                            <span>{{ $dayName }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- 4. Pesan Tutup Manual Kustom -->
            <div class="space-y-1.5 pt-2">
                <label for="closed_message" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                    Pesan Pemberitahuan Saat Toko Ditutup Sementara
                </label>
                <textarea name="closed_message" id="closed_message" rows="3" class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-xs font-medium text-slate-800 focus:ring-2 focus:ring-rose-500 outline-none leading-relaxed" placeholder="Contoh: Mohon maaf, saat ini stok dimsum habis dan sedang dalam proses produksi. Kami buka kembali segera.">{{ old('closed_message', $settings['closed_message']) }}</textarea>
                <span class="text-[11px] text-slate-400 block">Pesan ini akan ditampilkan di banner atas dan modal peringatan saat pelanggan membuka website toko ketika toko tutup.</span>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <button type="submit" class="btn-gradient text-white px-6 py-3 rounded-xl text-xs font-bold shadow-md flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Pengaturan Toko</span>
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
