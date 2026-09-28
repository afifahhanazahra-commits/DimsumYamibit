@extends('layouts.admin')

@section('title', 'Manajemen Pesanan & QRIS')
@section('header_title', 'Daftar Pesanan Masuk')

@section('content')
<div class="space-y-6">
    
    <!-- Tab Filter Navigation -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 border-b border-slate-200 text-xs font-bold">
        <a href="{{ route('admin.pesanan.index', ['status' => 'all']) }}" class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-2 flex-shrink-0 {{ $status === 'all' ? 'bg-rose-600 text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            <span>Semua Pesanan</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $status === 'all' ? 'bg-white/25 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $countAll }}</span>
        </a>

        <a href="{{ route('admin.pesanan.index', ['status' => 'menunggu']) }}" class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-2 flex-shrink-0 {{ $status === 'menunggu' ? 'bg-amber-500 text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            <i class="fa-solid fa-clock"></i>
            <span>Menunggu Bayar</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $status === 'menunggu' ? 'bg-white/25 text-white' : 'bg-amber-100 text-amber-800' }}">{{ $countMenunggu }}</span>
        </a>

        <a href="{{ route('admin.pesanan.index', ['status' => 'diproses']) }}" class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-2 flex-shrink-0 {{ $status === 'diproses' ? 'bg-blue-600 text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            <i class="fa-solid fa-fire-burner"></i>
            <span>Sedang Dikukus</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $status === 'diproses' ? 'bg-white/25 text-white' : 'bg-blue-100 text-blue-800' }}">{{ $countDiproses }}</span>
        </a>

        <a href="{{ route('admin.pesanan.index', ['status' => 'siap_diambil']) }}" class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-2 flex-shrink-0 {{ $status === 'siap_diambil' ? 'bg-purple-600 text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            <i class="fa-solid fa-bag-shopping"></i>
            <span>Siap Diambil</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $status === 'siap_diambil' ? 'bg-white/25 text-white' : 'bg-purple-100 text-purple-800' }}">{{ $countSiap }}</span>
        </a>

        <a href="{{ route('admin.pesanan.index', ['status' => 'selesai']) }}" class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-2 flex-shrink-0 {{ $status === 'selesai' ? 'bg-emerald-600 text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            <i class="fa-solid fa-check"></i>
            <span>Selesai</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $status === 'selesai' ? 'bg-white/25 text-white' : 'bg-emerald-100 text-emerald-800' }}">{{ $countSelesai }}</span>
        </a>

        <a href="{{ route('admin.pesanan.index', ['status' => 'ditolak']) }}" class="px-4 py-2.5 rounded-xl transition-all flex items-center gap-2 flex-shrink-0 {{ $status === 'ditolak' ? 'bg-rose-700 text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            <i class="fa-solid fa-circle-xmark"></i>
            <span>Bukti Ditolak</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $status === 'ditolak' ? 'bg-white/25 text-white' : 'bg-rose-100 text-rose-800' }}">{{ $countDitolak }}</span>
        </a>
    </div>

    <!-- Orders Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-100 text-slate-800 uppercase tracking-wider text-[11px] font-black border-y border-slate-200">
                    <tr>
                        <th class="px-5 py-4">Kode Transaksi</th>
                        <th class="px-5 py-4">Pelanggan & Kontak</th>
                        <th class="px-5 py-4">Metode</th>
                        <th class="px-5 py-4">Menu Dipesan</th>
                        <th class="px-5 py-4">Total</th>
                        <th class="px-5 py-4">Bukti QRIS</th>
                        <th class="px-5 py-4">Status Dapur</th>
                        <th class="px-5 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pesanans as $order)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- Kode -->
                            <td class="px-5 py-4 font-bold text-slate-900">
                                <span class="font-heading font-extrabold text-sm text-slate-900 block">#{{ $order->kode_pesanan }}</span>
                                <span class="text-[10px] font-medium text-slate-500">
                                    {{ $order->tanggal_pesanan ? $order->tanggal_pesanan->format('d/m/Y H:i') : '-' }}
                                </span>
                            </td>

                            <!-- Pelanggan -->
                            <td class="px-5 py-4">
                                <span class="font-bold text-slate-900 block">{{ $order->pelanggan ? $order->pelanggan->nama : '-' }}</span>
                                <a href="https://wa.me/{{ preg_replace('/^0/', '62', $order->pelanggan->no_hp ?? '') }}" target="_blank" class="text-[11px] text-emerald-600 hover:underline font-semibold flex items-center gap-1 mt-0.5">
                                    <i class="fa-brands fa-whatsapp"></i>
                                    {{ $order->pelanggan ? $order->pelanggan->no_hp : '-' }}
                                </a>
                            </td>

                            <!-- Metode -->
                            <td class="px-5 py-4">
                                <span class="uppercase font-bold text-[10px] px-2.5 py-1 rounded-lg {{ $order->metode_pengiriman === 'pickup' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-purple-50 text-purple-700 border border-purple-200' }}">
                                    {{ $order->metode_pengiriman === 'pickup' ? 'Pickup' : 'Ojol Mandiri' }}
                                </span>
                            </td>

                            <!-- Item Pesanan -->
                            <td class="px-5 py-4 max-w-xs">
                                <div class="space-y-0.5">
                                    @foreach($order->detailPesanan as $d)
                                        <div class="text-[11px] text-slate-700">
                                            <span class="font-bold text-slate-900">{{ $d->jumlah }}x</span> {{ $d->menu ? $d->menu->nama_menu : 'Item' }}
                                            @if($d->topping)
                                                <span class="text-[10px] text-rose-600 font-semibold">(+{{ $d->topping->nama_topping }})</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </td>

                            <!-- Total -->
                            <td class="px-5 py-4 font-black text-sm text-rose-600">
                                {{ $order->formatted_total }}
                            </td>

                            <!-- Status Bayar & Bukti -->
                            <td class="px-5 py-4">
                                @php $pBadge = $order->status_pembayaran_badge; @endphp
                                <span class="inline-block px-2.5 py-1 rounded-lg text-[10px] font-extrabold border {{ $pBadge['class'] }}">
                                    {{ $pBadge['label'] }}
                                </span>
                                @if($order->bukti_qris_url)
                                    <a href="{{ $order->bukti_qris_url }}" target="_blank" class="block text-[10px] text-rose-600 hover:underline font-bold mt-1">
                                        <i class="fa-solid fa-image"></i> Cek Foto Resi
                                    </a>
                                @endif
                            </td>

                            <!-- Status Dapur -->
                            <td class="px-5 py-4">
                                @php $oBadge = $order->status_pesanan_badge; @endphp
                                <span class="inline-block px-2.5 py-1 rounded-lg text-[10px] font-extrabold border {{ $oBadge['class'] }}">
                                    {{ $oBadge['label'] }}
                                </span>
                            </td>

                            <!-- Action -->
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.pesanan.show', $order->id_pesanan) }}" class="px-3.5 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm flex items-center gap-1.5">
                                        <i class="fa-solid fa-eye"></i>
                                        <span>Proses</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-12 text-center text-slate-400 italic">
                                Tidak ada data pesanan pada kategori filter ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pesanans->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $pesanans->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
