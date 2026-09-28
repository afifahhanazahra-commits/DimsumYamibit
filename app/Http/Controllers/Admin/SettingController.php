<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\StoreSchedule;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Tampilkan halaman pengaturan toko
     */
    public function index()
    {
        $settings = StoreSchedule::getSettings();
        $status = StoreSchedule::getStatus();

        return view('admin.pengaturan.index', compact('settings', 'status'));
    }

    /**
     * Simpan perubahan pengaturan operasional toko
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'mode' => 'required|in:auto,open,closed',
            'open_time' => 'required|date_format:H:i',
            'close_time' => 'required|date_format:H:i',
            'closed_days' => 'nullable|array',
            'closed_days.*' => 'integer|between:1,7',
            'closed_message' => 'nullable|string|max:255',
        ]);

        $closedDays = array_map('intval', $request->input('closed_days', []));

        StoreSchedule::saveSettings([
            'mode' => $validated['mode'],
            'open_time' => $validated['open_time'],
            'close_time' => $validated['close_time'],
            'closed_days' => $closedDays,
            'closed_message' => $validated['closed_message'] ?? 'Mohon maaf, saat ini toko sedang tutup sementara.',
        ]);

        return redirect()->route('admin.pengaturan.index')->with('success', 'Pengaturan buka/tutup toko berhasil disimpan!');
    }

    /**
     * Quick toggle mode toko (1-klik: auto / open / closed)
     */
    public function quickToggle(Request $request)
    {
        $request->validate([
            'mode' => 'required|in:auto,open,closed',
        ]);

        StoreSchedule::saveSettings([
            'mode' => $request->mode,
        ]);

        $statusMsg = match ($request->mode) {
            'open' => 'Status toko berhasil diubah menjadi: BUKA PAKSA (Manual Open)!',
            'closed' => 'Status toko berhasil diubah menjadi: TUTUP SEMENTARA (Manual Closed)!',
            default => 'Status toko dikembalikan ke: OTOMATIS (Mengikuti Jadwal Jam & Hari)!',
        };

        return back()->with('success', $statusMsg);
    }
}
