<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Topping;
use Illuminate\Http\Request;

class ToppingController extends Controller
{
    public function index()
    {
        $toppings = Topping::orderBy('id_topping', 'asc')->get();
        return view('admin.topping.index', compact('toppings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_topping' => 'required|string|max:50',
            'harga_tambahan' => 'required|integer|min:0',
        ], [
            'nama_topping.required' => 'Nama topping/saus wajib diisi.',
            'harga_tambahan.required' => 'Harga tambahan wajib diisi.',
        ]);

        $topping = Topping::create([
            'nama_topping' => $request->nama_topping,
            'harga_tambahan' => $request->harga_tambahan,
        ]);

        return redirect()->route('admin.topping.index')
            ->with('success', "Topping/Saus '{$topping->nama_topping}' berhasil ditambahkan.");
    }

    public function update(Request $request, $id)
    {
        $topping = Topping::findOrFail($id);

        $request->validate([
            'nama_topping' => 'required|string|max:50',
            'harga_tambahan' => 'required|integer|min:0',
        ]);

        $topping->update([
            'nama_topping' => $request->nama_topping,
            'harga_tambahan' => $request->harga_tambahan,
        ]);

        return redirect()->route('admin.topping.index')
            ->with('success', "Topping/Saus '{$topping->nama_topping}' berhasil diperbarui.");
    }

    public function destroy($id)
    {
        $topping = Topping::findOrFail($id);
        $nama = $topping->nama_topping;
        $topping->delete();

        return redirect()->route('admin.topping.index')
            ->with('success', "Topping/Saus '{$nama}' berhasil dihapus.");
    }
}
