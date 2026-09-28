<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('stok')->orderBy('id_menu', 'asc')->get();
        return view('admin.menu.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:100',
            'deskripsi' => 'nullable|string|max:255',
            'harga' => 'required|integer|min:0',
            'stok_awal' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,habis',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = 'menu_' . time() . '_' . Str::slug($request->nama_menu) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/menu'), $filename);
            $fotoPath = 'uploads/menu/' . $filename;
        }

        $menu = Menu::create([
            'nama_menu' => $request->nama_menu,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'status' => $request->status,
            'foto' => $fotoPath,
        ]);

        Stok::create([
            'id_menu' => $menu->id_menu,
            'jumlah_stok' => $request->stok_awal,
            'update_terakhir' => now(),
        ]);

        return redirect()->route('admin.menu.index')
            ->with('success', "Menu '{$menu->nama_menu}' berhasil ditambahkan.");
    }

    public function edit($id)
    {
        $menu = Menu::with('stok')->findOrFail($id);
        return view('admin.menu.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'nama_menu' => 'required|string|max:100',
            'deskripsi' => 'nullable|string|max:255',
            'harga' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,habis',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $fotoPath = $menu->foto;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = 'menu_' . time() . '_' . Str::slug($request->nama_menu) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/menu'), $filename);
            $fotoPath = 'uploads/menu/' . $filename;
        }

        $menu->update([
            'nama_menu' => $request->nama_menu,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'status' => $request->status,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('admin.menu.index')
            ->with('success', "Menu '{$menu->nama_menu}' berhasil diperbarui.");
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $nama = $menu->nama_menu;
        $menu->delete();

        return redirect()->route('admin.menu.index')
            ->with('success', "Menu '{$nama}' berhasil dihapus.");
    }
}
