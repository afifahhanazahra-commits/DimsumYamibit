@extends('layouts.admin')

@section('title', 'Tambah Menu Baru')
@section('header_title', 'Tambah Menu Dimsum Baru')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.menu.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 inline-flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Katalog Menu
        </a>
    </div>

    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
        <div class="border-b border-slate-100 pb-4">
            <h2 class="text-lg font-bold font-heading text-slate-900">Formulir Tambah Menu Dimsum</h2>
            <p class="text-xs text-slate-400">Masukkan nama produk, harga satuan, stok awal, dan foto menu.</p>
        </div>

        <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <label for="nama_menu" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Nama Menu / Produk <span class="text-rose-600">*</span>
                </label>
                <input type="text" name="nama_menu" id="nama_menu" value="{{ old('nama_menu') }}" required placeholder="Contoh: Dimsum Mozarella" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 outline-none">
                @error('nama_menu')
                    <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="deskripsi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Deskripsi Singkat / Bahan Utama
                </label>
                <textarea name="deskripsi" id="deskripsi" rows="2" placeholder="Contoh: Dimsum olahan ayam dengan topping keju lumer..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 outline-none">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="harga" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Harga Satuan (Rp) <span class="text-rose-600">*</span>
                    </label>
                    <input type="number" name="harga" id="harga" value="{{ old('harga', 15000) }}" required min="0" step="500" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 outline-none font-bold">
                    @error('harga')
                        <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stok_awal" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Stok Fisik Awal (Porsi) <span class="text-rose-600">*</span>
                    </label>
                    <input type="number" name="stok_awal" id="stok_awal" value="{{ old('stok_awal', 30) }}" required min="0" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 outline-none font-bold">
                    @error('stok_awal')
                        <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Status Ketersediaan <span class="text-rose-600">*</span>
                    </label>
                    <select name="status" id="status" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 outline-none font-bold">
                        <option value="tersedia" {{ old('status') === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="habis" {{ old('status') === 'habis' ? 'selected' : '' }}>Habis</option>
                    </select>
                </div>

                <div>
                    <label for="foto" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Foto Produk (Opsional)
                    </label>
                    <input type="file" name="foto" id="foto" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.menu.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition-colors">
                    Batal
                </a>
                <button type="submit" class="btn-gradient text-white px-6 py-2.5 rounded-xl text-xs font-bold shadow-md flex items-center gap-2">
                    <i class="fa-solid fa-save"></i>
                    <span>Simpan Menu</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
