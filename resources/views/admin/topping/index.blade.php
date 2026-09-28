@extends('layouts.admin')

@section('title', 'Varian Topping & Saus Ekstra')
@section('header_title', 'Manajemen Topping & Saus')

@section('content')
<div class="space-y-6">
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left: Form Tambah Topping Baru -->
        <div class="lg:col-span-5 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6 self-start">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="font-bold font-heading text-slate-900 text-base">Tambah Varian Saus / Topping</h3>
                <p class="text-xs text-slate-400">Tambahkan opsi saus tambahan untuk menu dimsum.</p>
            </div>

            <form action="{{ route('admin.topping.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="nama_topping" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Nama Topping / Saus <span class="text-rose-600">*</span>
                    </label>
                    <input type="text" name="nama_topping" id="nama_topping" value="{{ old('nama_topping') }}" required placeholder="Contoh: Saus Keju Lumer" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:border-rose-500 focus:ring-1 focus:ring-rose-500 outline-none">
                    @error('nama_topping')
                        <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="harga_tambahan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Harga Tambahan (Rp) <span class="text-rose-600">*</span>
                    </label>
                    <input type="number" name="harga_tambahan" id="harga_tambahan" value="{{ old('harga_tambahan', 3000) }}" required min="0" step="500" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm font-bold focus:border-rose-500 focus:ring-1 focus:ring-rose-500 outline-none">
                    <p class="text-[11px] text-slate-400 mt-1">Masukkan 0 jika topping diberikan secara gratis.</p>
                    @error('harga_tambahan')
                        <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full btn-gradient text-white py-3 px-4 rounded-xl text-xs font-bold shadow-md flex items-center justify-center gap-2">
                    <i class="fa-solid fa-plus"></i>
                    <span>Simpan Topping</span>
                </button>
            </form>
        </div>

        <!-- Right: Daftar Topping yang Ada -->
        <div class="lg:col-span-7 bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-6 sm:p-8 space-y-4">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="font-bold font-heading text-slate-900 text-base">Daftar Pilihan Topping Aktif</h3>
                <p class="text-xs text-slate-400">Pilihan topping ini akan muncul otomatis saat pelanggan memilih menu.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-100 text-slate-800 uppercase tracking-wider text-[11px] font-black border-y border-slate-200">
                        <tr>
                            <th class="px-4 py-3 rounded-l-xl">No</th>
                            <th class="px-4 py-3">Nama Varian</th>
                            <th class="px-4 py-3">Harga Tambahan</th>
                            <th class="px-4 py-3 text-right rounded-r-xl">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($toppings as $idx => $top)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-4 py-3 font-bold text-slate-400 w-12">{{ $idx + 1 }}</td>
                                <td class="px-4 py-3 font-bold text-slate-900 text-sm">{{ $top->nama_topping }}</td>
                                <td class="px-4 py-3 font-extrabold text-rose-600 text-sm">{{ $top->formatted_harga }}</td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button" onclick="openEditToppingModal({{ $top->id_topping }}, '{{ addslashes($top->nama_topping) }}', {{ $top->harga_tambahan }})" class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-bold transition-colors">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>

                                        <form action="{{ route('admin.topping.destroy', $top->id_topping) }}" method="POST" onsubmit="return confirm('Hapus topping {{ $top->nama_topping }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg text-xs font-bold transition-colors">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-slate-400 italic">
                                    Belum ada data topping yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

<!-- Modal: Ubah Topping -->
<div id="edit-topping-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
    <div class="relative bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="font-bold font-heading text-slate-900 text-base">Ubah Varian Topping</h3>
            <button onclick="closeEditToppingModal()" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form id="edit-topping-form" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="edit_nama_topping" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Nama Topping
                </label>
                <input type="text" name="nama_topping" id="edit_nama_topping" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:border-rose-500 outline-none">
            </div>

            <div>
                <label for="edit_harga_tambahan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                    Harga Tambahan (Rp)
                </label>
                <input type="number" name="harga_tambahan" id="edit_harga_tambahan" required min="0" step="500" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm font-bold focus:border-rose-500 outline-none">
            </div>

            <div class="pt-2 flex justify-end gap-2">
                <button type="button" onclick="closeEditToppingModal()" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl text-xs font-bold">
                    Batal
                </button>
                <button type="submit" class="btn-gradient text-white px-5 py-2 rounded-xl text-xs font-bold shadow-md">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openEditToppingModal(id, name, price) {
        document.getElementById('edit_nama_topping').value = name;
        document.getElementById('edit_harga_tambahan').value = price;
        document.getElementById('edit-topping-form').action = `/admin/topping/${id}`;
        document.getElementById('edit-topping-modal').classList.remove('hidden');
    }
    function closeEditToppingModal() {
        document.getElementById('edit-topping-modal').classList.add('hidden');
    }
</script>
@endsection
