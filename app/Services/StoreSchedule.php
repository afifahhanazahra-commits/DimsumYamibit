<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class StoreSchedule
{
    protected static string $settingsFileName = 'store_settings.json';

    /**
     * Dapatkan konfigurasi pengaturan toko saat ini
     */
    public static function getSettings(): array
    {
        $default = [
            'mode' => 'auto', // 'auto' (otomatis jadwal), 'open' (buka paksa), 'closed' (tutup paksa)
            'open_time' => '14:30',
            'close_time' => '21:00',
            'closed_days' => [1], // 1 = Senin, 2 = Selasa, dst.
            'closed_message' => 'Mohon maaf, saat ini pemesanan ditutup sementara oleh pengelola toko.',
        ];

        try {
            if (Storage::disk('local')->exists(self::$settingsFileName)) {
                $content = Storage::disk('local')->get(self::$settingsFileName);
                $decoded = json_decode($content, true);
                if (is_array($decoded)) {
                    return array_merge($default, $decoded);
                }
            }
        } catch (\Throwable $e) {
            // fallback to default
        }

        return $default;
    }

    /**
     * Simpan pembaruan pengaturan toko
     */
    public static function saveSettings(array $newSettings): bool
    {
        $current = self::getSettings();
        $merged = array_merge($current, $newSettings);
        return Storage::disk('local')->put(self::$settingsFileName, json_encode($merged, JSON_PRETTY_PRINT));
    }

    /**
     * Cek status buka/tutup toko saat ini
     */
    public static function getStatus(): array
    {
        $now = Carbon::now('Asia/Jakarta');
        $settings = self::getSettings();

        // 1. Dukungan simulasi / testing via URL query parameter atau session
        if (function_exists('app') && app()->bound('request') && request() !== null) {
            if (request()->has('toko')) {
                $qMode = strtolower(request()->query('toko'));
                if ($qMode === 'buka' || $qMode === 'open') {
                    if (app()->bound('session') && session() !== null) session(['simulate_store' => 'open']);
                } elseif ($qMode === 'tutup' || $qMode === 'closed') {
                    if (app()->bound('session') && session() !== null) session(['simulate_store' => 'closed']);
                } elseif ($qMode === 'reset') {
                    if (app()->bound('session') && session() !== null) session()->forget('simulate_store');
                }
            }
        }

        if (function_exists('app') && app()->bound('session') && session() !== null) {
            if (session('simulate_store') === 'open') {
                return [
                    'is_open' => true,
                    'mode' => 'simulation_open',
                    'status_label' => 'BUKA SEKARANG (SIMULASI)',
                    'badge_color' => 'bg-emerald-600 text-white',
                    'badge_icon' => 'fa-circle-check',
                    'message' => 'Toko sedang BUKA! Silakan pesan dimsum lezat favoritmu sekarang.',
                    'next_open' => null,
                    'current_time' => $now->translatedFormat('l, d F Y - H:i') . ' WIB',
                    'schedule_text' => 'Buka: ' . $settings['open_time'] . ' - ' . $settings['close_time'] . ' WIB',
                    'is_simulation' => true,
                ];
            }

            if (session('simulate_store') === 'closed') {
                return [
                    'is_open' => false,
                    'mode' => 'simulation_closed',
                    'status_label' => 'SEDANG TUTUP (SIMULASI)',
                    'badge_color' => 'bg-rose-600 text-white',
                    'badge_icon' => 'fa-lock',
                    'message' => 'Mohon maaf, fitur pesanan dinonaktifkan sementara.',
                    'next_open' => 'Jam operasional berikutnya pukul ' . $settings['open_time'] . ' WIB',
                    'current_time' => $now->translatedFormat('l, d F Y - H:i') . ' WIB',
                    'schedule_text' => 'Buka: ' . $settings['open_time'] . ' - ' . $settings['close_time'] . ' WIB',
                    'is_simulation' => true,
                ];
            }
        }

        // 2. Override Manual dari Admin Panel
        if ($settings['mode'] === 'open') {
            return [
                'is_open' => true,
                'mode' => 'manual_open',
                'status_label' => 'BUKA SEKARANG (MANUAL)',
                'badge_color' => 'bg-emerald-600 text-white',
                'badge_icon' => 'fa-circle-check',
                'message' => 'Toko Dimsum Yamibit siap melayani pesanan Anda! Silakan pilih menu favorit.',
                'next_open' => null,
                'current_time' => $now->translatedFormat('l, d F Y - H:i') . ' WIB',
                'schedule_text' => 'Dibuka Manual oleh Pengelola Toko',
                'is_simulation' => false,
            ];
        }

        if ($settings['mode'] === 'closed') {
            return [
                'is_open' => false,
                'mode' => 'manual_closed',
                'status_label' => 'TUTUP SEMENTARA',
                'badge_color' => 'bg-rose-600 text-white',
                'badge_icon' => 'fa-lock',
                'message' => $settings['closed_message'] ?: 'Mohon maaf, saat ini toko sedang tutup sementara.',
                'next_open' => 'Segera dibuka kembali oleh pengelola',
                'current_time' => $now->translatedFormat('l, d F Y - H:i') . ' WIB',
                'schedule_text' => 'Ditutup Sementara Secara Manual',
                'is_simulation' => false,
            ];
        }

        // 3. Mode Otomatis Berdasarkan Jam Operasional & Hari Libur (WIB)
        $dayOfWeek = $now->dayOfWeekIso; // 1 = Senin, 2 = Selasa, ..., 7 = Minggu
        $currentTimeStr = $now->format('H:i');
        $openTimeStr = $settings['open_time'] ?? '14:30';
        $closeTimeStr = $settings['close_time'] ?? '21:00';
        $closedDays = $settings['closed_days'] ?? [1];

        // Cek apakah hari ini termasuk hari libur
        if (in_array($dayOfWeek, $closedDays)) {
            $dayNames = [1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu', 7 => 'Minggu'];
            $todayName = $dayNames[$dayOfWeek] ?? 'Hari ini';
            return [
                'is_open' => false,
                'mode' => 'auto',
                'status_label' => "LIBUR ({$todayName} TUTUP)",
                'badge_color' => 'bg-rose-600 text-white',
                'badge_icon' => 'fa-calendar-xmark',
                'message' => "Hari {$todayName} toko Dimsum Yamibit libur. Kami buka kembali pada hari operasional berikutnya pukul {$openTimeStr} WIB.",
                'next_open' => "Besok pukul {$openTimeStr} WIB",
                'current_time' => $now->translatedFormat('l, d F Y - H:i') . ' WIB',
                'schedule_text' => "Selasa - Minggu: {$openTimeStr} - {$closeTimeStr} WIB (Senin Tutup)",
                'is_simulation' => false,
            ];
        }

        // Sebelum jam buka
        if ($currentTimeStr < $openTimeStr) {
            return [
                'is_open' => false,
                'mode' => 'auto',
                'status_label' => 'BELUM BUKA',
                'badge_color' => 'bg-amber-500 text-white',
                'badge_icon' => 'fa-clock',
                'message' => "Toko Dimsum Yamibit belum buka. Fitur pesanan online akan aktif otomatis hari ini pukul {$openTimeStr} WIB.",
                'next_open' => "Hari ini pukul {$openTimeStr} WIB",
                'current_time' => $now->translatedFormat('l, d F Y - H:i') . ' WIB',
                'schedule_text' => "Selasa - Minggu: {$openTimeStr} - {$closeTimeStr} WIB (Senin Tutup)",
                'is_simulation' => false,
            ];
        }

        // Setelah jam tutup
        if ($currentTimeStr >= $closeTimeStr) {
            $nextDay = ($dayOfWeek === 7) ? 'Selasa' : 'Besok';
            return [
                'is_open' => false,
                'mode' => 'auto',
                'status_label' => 'SUDAH TUTUP',
                'badge_color' => 'bg-slate-700 text-white',
                'badge_icon' => 'fa-moon',
                'message' => "Toko Dimsum Yamibit sudah tutup untuk hari ini. Fitur pemesanan dibuka kembali {$nextDay} pukul {$openTimeStr} WIB.",
                'next_open' => "{$nextDay} pukul {$openTimeStr} WIB",
                'current_time' => $now->translatedFormat('l, d F Y - H:i') . ' WIB',
                'schedule_text' => "Selasa - Minggu: {$openTimeStr} - {$closeTimeStr} WIB (Senin Tutup)",
                'is_simulation' => false,
            ];
        }

        // Toko Buka Normal
        return [
            'is_open' => true,
            'mode' => 'auto',
            'status_label' => 'BUKA SEKARANG',
            'badge_color' => 'bg-emerald-600 text-white',
            'badge_icon' => 'fa-circle-check',
            'message' => 'Toko sedang BUKA! Silakan pilih menu dan pesan dimsum hangat favoritmu.',
            'next_open' => null,
            'current_time' => $now->translatedFormat('l, d F Y - H:i') . ' WIB',
            'schedule_text' => "Selasa - Minggu: {$openTimeStr} - {$closeTimeStr} WIB (Senin Tutup)",
            'is_simulation' => false,
        ];
    }
}
