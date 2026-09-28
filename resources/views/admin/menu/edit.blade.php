@extends('layouts.admin')

@section('title', 'Ubah Menu - ' . $menu->nama_menu)
@section('header_title', 'Ubah Data Menu Dimsum')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.menu.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 inline-flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Katalog Menu
        </a>
    </div>

    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
        <div class="border-b border-slate-100 pb-4">
            <h2 class="text-lg font-bold font-heading text-slate-900">Ubah Menu: {{ $menu->nama_menu }}</h2>
            <p class="text-xs text-slate-400">Perbarui rincian produk, harga satuan, atau foto menu.</p>
        </div>

        <form action="{{ route('admin.menu.update', $menu->id_menu) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="nama_menu" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Nama Menu / Produk <span class="text-rose-600">*</span>
                </label>
                <input type="text" name="nama_menu" id="nama_menu" value="{{ old('nama_menu', $menu->nama_menu) }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 outline-none">
                @error('nama_menu')
                    <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="deskripsi" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Deskripsi Singkat / Bahan Utama
                </label>
                <textarea name="deskripsi" id="deskripsi" rows="2" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 outline-none">{{ old('deskripsi', $menu->deskripsi) }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="harga" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Harga Satuan (Rp) <span class="text-rose-600">*</span>
                    </label>
                    <input type="number" name="harga" id="harga" value="{{ old('harga', $menu->harga) }}" required min="0" step="500" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 outline-none font-bold">
                    @error('harga')
                        <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Status Ketersediaan <span class="text-rose-600">*</span>
                    </label>
                    <select name="status" id="status" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 outline-none font-bold">
                        <option value="tersedia" {{ old('status', $menu->status) === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="habis" {{ old('status', $menu->status) === 'habis' ? 'selected' : '' }}>Habis</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="foto" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Ganti Foto Produk (Kosongkan jika tidak ingin diubah)
                </label>
                @if($menu->foto_url)
                    <div class="mb-2 flex items-center gap-3">
                        <img src="{{ $menu->foto_url }}" alt="{{ $menu->nama_menu }}" class="w-14 h-14 rounded-xl object-cover border border-slate-200">
                        <span class="text-xs text-slate-400">Foto saat ini</span>
                    </div>
                @endif
                <input type="file" name="foto" id="foto" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-rose-50 file:text-rose-700 hover:file:bg-rose-100">
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.menu.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition-colors">
                    Batal
                </a>
                <button type="submit" class="btn-gradient text-white px-6 py-2.5 rounded-xl text-xs font-bold shadow-md flex items-center gap-2">
                    <i class="fa-solid fa-save"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
