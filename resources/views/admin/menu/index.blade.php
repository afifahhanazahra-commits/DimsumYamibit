@extends('layouts.admin')

@section('title', 'Katalog Menu Dimsum')
@section('header_title', 'Manajemen Katalog Menu')

@section('content')
<div class="space-y-6">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-base font-bold font-heading text-slate-900">Daftar Produk Dimsum & Camilan</h2>
            <p class="text-xs text-slate-400">Kelola varian menu, harga porsi, foto produk, dan status ketersediaan.</p>
        </div>
        
        <a href="{{ route('admin.menu.create') }}" class="btn-gradient text-white px-5 py-2.5 rounded-xl font-bold text-xs shadow-md flex items-center gap-2 self-start sm:self-auto">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Menu Baru</span>
        </a>
    </div>

    <!-- Menu Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-100 text-slate-800 uppercase tracking-wider text-[11px] font-black border-y border-slate-200">
                    <tr>
                        <th class="px-5 py-4">Foto</th>
                        <th class="px-5 py-4">Nama Menu</th>
                        <th class="px-5 py-4">Deskripsi</th>
                        <th class="px-5 py-4">Harga Satuan</th>
                        <th class="px-5 py-4">Stok Fisik</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($menus as $menu)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- Foto -->
                            <td class="px-5 py-3">
                                <div class="w-14 h-14 rounded-xl bg-slate-900 overflow-hidden flex items-center justify-center border border-slate-200 flex-shrink-0">
                                    <img src="{{ $menu->foto_url }}" alt="{{ $menu->nama_menu }}" class="w-full h-full object-cover" onerror="this.src='https://images.unsplash.com/photo-1563245372-f21724e3856d?w=200&auto=format&fit=crop&q=80'">
                                </div>
                            </td>

                            <!-- Nama -->
                            <td class="px-5 py-3 font-extrabold text-slate-900 text-sm">
                                {{ $menu->nama_menu }}
                            </td>

                            <!-- Deskripsi -->
                            <td class="px-5 py-3 max-w-xs text-slate-500 text-[11px]">
                                {{ $menu->deskripsi ?: '-' }}
                            </td>

                            <!-- Harga -->
                            <td class="px-5 py-3 font-black text-sm text-rose-600">
                                {{ $menu->formatted_harga }}
                            </td>

                            <!-- Stok Fisik -->
                            <td class="px-5 py-3">
                                @if($menu->stok)
                                    @php $sBadge = $menu->stok->status_badge; @endphp
                                    <span class="inline-block px-2.5 py-1 rounded-lg text-[10px] font-extrabold border {{ $sBadge['class'] }}">
                                        {{ $sBadge['label'] }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic">0</span>
                                @endif
                            </td>

                            <!-- Status -->
                            <td class="px-5 py-3">
                                @if($menu->status === 'tersedia')
                                    <span class="inline-block px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Tersedia
                                    </span>
                                @else
                                    <span class="inline-block px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-rose-50 text-rose-700 border border-rose-200">
                                        Habis
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="px-5 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.menu.edit', $menu->id_menu) }}" class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-bold transition-colors" title="Ubah Menu">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <form action="{{ route('admin.menu.destroy', $menu->id_menu) }}" method="POST" onsubmit="return confirm('Hapus menu {{ $menu->nama_menu }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg text-xs font-bold transition-colors" title="Hapus Menu">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-slate-400 italic">
                                Belum ada data menu. Silakan klik tombol 'Tambah Menu Baru'.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
