<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Stok;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index()
    {
        $stoks = Stok::with('menu')
            ->join('menu', 'stok.id_menu', '=', 'menu.id_menu')
            ->select('stok.*')
            ->orderBy('menu.nama_menu', 'asc')
            ->get();

        $totalStok = $stoks->sum('jumlah_stok');
        $stokKritis = $stoks->where('jumlah_stok', '<=', 10)->count();

        return view('admin.stok.index', compact('stoks', 'totalStok', 'stokKritis'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah_stok' => 'required|integer|min:0',
        ]);

        $stok = Stok::findOrFail($id);
        $stok->update([
            'jumlah_stok' => $request->jumlah_stok,
            'update_terakhir' => now(),
        ]);

        // Otomatis sinkronkan status menu jika stok diisi kembali atau habis
        $menu = Menu::find($stok->id_menu);
        if ($menu) {
            if ($request->jumlah_stok > 0 && $menu->status === 'habis') {
                $menu->update(['status' => 'tersedia']);
            } elseif ($request->jumlah_stok <= 0) {
                $menu->update(['status' => 'habis']);
            }
        }

        return redirect()->route('admin.stok.index')
            ->with('success', "Stok untuk menu '{$menu->nama_menu}' berhasil diperbarui menjadi {$request->jumlah_stok} porsi.");
    }
}
