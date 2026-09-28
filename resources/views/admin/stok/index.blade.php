@extends('layouts.admin')

@section('title', 'Manajemen Stok Real-Time')
@section('header_title', 'Pengawasan Stok & Inventaris Produk')

@section('content')
<div class="space-y-6">
    
    <!-- Header Metrics -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-extrabold uppercase tracking-wider text-slate-400">Total Stok Fisik</span>
                <h3 class="text-2xl font-extrabold font-heading text-slate-900">{{ $totalStok }} Porsi</h3>
                <span class="text-[11px] text-emerald-600 font-semibold">Siap dijual di dapur</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-extrabold uppercase tracking-wider text-slate-400">Stok Kritis (&le; 10 Porsi)</span>
                <h3 class="text-2xl font-extrabold font-heading text-rose-600">{{ $stokKritis }} Menu</h3>
                <span class="text-[11px] text-rose-500 font-semibold">Perlu produksi ulang</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-extrabold uppercase tracking-wider text-slate-400">Otomatisasi Sistem</span>
                <h3 class="text-lg font-extrabold font-heading text-slate-900">Real-Time Sync</h3>
                <span class="text-[11px] text-slate-500">Stok terpotong saat bayar valid</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-bolt"></i>
            </div>
        </div>
    </div>

    <!-- Stock Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden p-6 sm:p-8 space-y-4">
        <div class="border-b border-slate-100 pb-3 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <h3 class="font-bold font-heading text-slate-900 text-base">Daftar Persediaan Dimsum</h3>
                <p class="text-xs text-slate-400">Pembaruan stok fisik akan langsung mempengaruhi status 'Tersedia/Habis' pada katalog pelanggan.</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-100 text-slate-800 uppercase tracking-wider text-[11px] font-black border-y border-slate-200">
                    <tr>
                        <th class="px-5 py-3.5 rounded-l-xl">Nama Produk Dimsum</th>
                        <th class="px-5 py-3.5">Harga Porsi</th>
                        <th class="px-5 py-3.5">Sisa Stok Fisik</th>
                        <th class="px-5 py-3.5">Status Persediaan</th>
                        <th class="px-5 py-3.5">Pembaruan Terakhir</th>
                        <th class="px-5 py-3.5 text-right rounded-r-xl">Aksi Cepat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($stoks as $stok)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-5 py-4 font-extrabold text-slate-900 text-sm">
                                {{ $stok->menu ? $stok->menu->nama_menu : 'Menu' }}
                            </td>
                            <td class="px-5 py-4">
                                <span class="font-extrabold text-rose-600 text-sm bg-rose-50 px-2.5 py-1 rounded-lg border border-rose-100 inline-block">
                                    {{ $stok->menu ? $stok->menu->formatted_harga : '-' }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-black {{ $stok->jumlah_stok <= 0 ? 'bg-rose-100 text-rose-700 border border-rose-200' : ($stok->jumlah_stok <= 10 ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-slate-100 text-slate-800 border border-slate-200') }}">
                                    <i class="fa-solid fa-boxes-stacked text-[10px]"></i>
                                    <span>{{ $stok->jumlah_stok }} porsi</span>
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                @php $sBadge = $stok->status_badge; @endphp
                                <span class="inline-block px-3 py-1 rounded-xl text-[10px] font-extrabold border {{ $sBadge['class'] }}">
                                    {{ $sBadge['label'] }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-slate-600 font-medium text-[11px]">
                                {{ $stok->update_terakhir ? $stok->update_terakhir->format('d/m/Y H:i:s') : '-' }}
                            </td>
                            <td class="px-5 py-4 text-right">
                                <button type="button" onclick="openUpdateStockModal({{ $stok->id_stok }}, '{{ addslashes($stok->menu->nama_menu ?? '') }}', {{ $stok->jumlah_stok }})" class="btn-gradient text-white px-4 py-2 rounded-xl text-xs font-bold shadow-sm flex items-center gap-1.5 ml-auto">
                                    <i class="fa-solid fa-arrows-rotate text-[11px]"></i>
                                    <span>Atur Stok</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-slate-400 italic">
                                Belum ada data stok yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal: Update Stock Quick Dialog -->
<div id="update-stock-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
    <div class="relative bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="font-bold font-heading text-slate-900 text-base">Atur Jumlah Stok Fisik</h3>
            <button onclick="closeUpdateStockModal()" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form id="update-stock-form" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Nama Menu Dimsum:
                </label>
                <input type="text" id="modal-stock-menu-name" readonly class="w-full px-4 py-2.5 bg-slate-100 border border-slate-200 rounded-xl text-sm font-bold text-slate-700">
            </div>

            <div>
                <label for="modal-stock-qty" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Jumlah Stok Fisik Baru (Porsi) <span class="text-rose-600">*</span>
                </label>
                <input type="number" name="jumlah_stok" id="modal-stock-qty" required min="0" class="w-full px-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-lg font-extrabold text-slate-900 focus:border-rose-500 focus:ring-1 focus:ring-rose-500 outline-none">
                <p class="text-[11px] text-slate-400 mt-1">Jika diisi 0, menu akan otomatis diberi tanda 'Habis' pada katalog pembeli.</p>
            </div>

            <div class="pt-2 flex justify-end gap-2">
                <button type="button" onclick="closeUpdateStockModal()" class="px-4 py-2.5 bg-slate-100 text-slate-700 rounded-xl text-xs font-bold">
                    Batal
                </button>
                <button type="submit" class="btn-gradient text-white px-5 py-2.5 rounded-xl text-xs font-bold shadow-md">
                    Simpan Perubahan Stok
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openUpdateStockModal(id, name, qty) {
        document.getElementById('modal-stock-menu-name').value = name;
        document.getElementById('modal-stock-qty').value = qty;
        document.getElementById('update-stock-form').action = `/admin/stok/${id}`;
        document.getElementById('update-stock-modal').classList.remove('hidden');
    }
    function closeUpdateStockModal() {
        document.getElementById('update-stock-modal').classList.add('hidden');
    }
</script>
@endsection
