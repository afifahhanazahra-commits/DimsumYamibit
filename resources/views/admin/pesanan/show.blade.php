@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $pesanan->kode_pesanan)
@section('header_title', 'Pemrosesan Pesanan #' . $pesanan->kode_pesanan)

@section('content')
<div class="space-y-8">
    
    <!-- Top Back & Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <a href="{{ route('admin.pesanan.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 inline-flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Pesanan
        </a>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.pesanan.struk', $pesanan->id_pesanan) }}" target="_blank" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded-xl text-xs font-bold transition-colors flex items-center gap-2 border border-slate-300">
                <i class="fa-solid fa-print text-rose-600"></i>
                <span>Cetak Nota Dapur (Kitchen Slip)</span>
            </a>

            <!-- Direct WA Customer Link -->
            @php
                $cleanPhone = preg_replace('/^0/', '62', $pesanan->pelanggan->no_hp ?? '');
                $waMsg = "Halo kak *{$pesanan->pelanggan->nama}*, ini dari *Dimsum Yamibit* mengenai pesanan *#{$pesanan->kode_pesanan}*.\n\nStatus pesanan saat ini: *" . ucfirst(str_replace('_', ' ', $pesanan->status_pesanan)) . "*.\nTotal pembayaran: Rp " . number_format($pesanan->total_harga, 0, ',', '.') . ".\n\nTerima kasih!";
                $waUrl = "https://api.whatsapp.com/send?phone={$cleanPhone}&text=" . rawurlencode($waMsg);
            @endphp
            <a href="{{ $waUrl }}" target="_blank" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-colors flex items-center gap-2 shadow-sm">
                <i class="fa-brands fa-whatsapp text-sm"></i>
                <span>Hubungi Pelanggan</span>
            </a>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left Column: Verification & Status Actions -->
        <div class="lg:col-span-5 space-y-6">
            
            <!-- 1. Payment Verification Box -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="font-bold font-heading text-slate-900 text-base">Verifikasi Pembayaran QRIS</h3>
                    @php $pBadge = $pesanan->status_pembayaran_badge; @endphp
                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold border {{ $pBadge['class'] }}">
                        {{ $pBadge['label'] }}
                    </span>
                </div>

                <!-- Proof Image Preview -->
                <div class="space-y-2">
                    <span class="text-xs text-slate-500 font-bold block">Foto Bukti Transfer Pelanggan:</span>
                    
                    @if($pesanan->bukti_qris_url)
                        <div class="rounded-2xl border-2 border-slate-200 overflow-hidden bg-slate-900 group relative cursor-pointer" onclick="openImageModal('{{ $pesanan->bukti_qris_url }}')">
                            <img src="{{ $pesanan->bukti_qris_url }}" alt="Bukti Transfer QRIS" class="w-full max-h-60 object-contain mx-auto group-hover:opacity-90 transition-opacity">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-xs font-bold gap-2">
                                <i class="fa-solid fa-magnifying-glass-plus text-base"></i>
                                <span>Klik untuk Perbesar</span>
                            </div>
                        </div>
                    @else
                        <div class="p-8 text-center bg-slate-50 rounded-2xl border border-slate-200 text-slate-400 text-xs italic">
                            Belum ada bukti pembayaran yang diunggah.
                        </div>
                    @endif
                </div>

                <!-- Verification Action Form -->
                <form action="{{ route('admin.pesanan.verify', $pesanan->id_pesanan) }}" method="POST" class="pt-2 space-y-3">
                    @csrf
                    <div class="grid grid-cols-2 gap-3">
                        <button type="submit" name="status_pembayaran" value="valid" onclick="return confirm('Konfirmasi pembayaran VALID? Stok dimsum akan otomatis dipotong secara real-time!')" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-md transition-colors flex items-center justify-center gap-1.5">
                            <i class="fa-solid fa-circle-check"></i>
                            <span>Terima (Valid)</span>
                        </button>

                        <button type="submit" name="status_pembayaran" value="ditolak" onclick="return confirm('Tolak bukti pembayaran ini? Pelanggan akan diminta mengunggah ulang.')" class="w-full py-3 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold shadow-md transition-colors flex items-center justify-center gap-1.5">
                            <i class="fa-solid fa-circle-xmark"></i>
                            <span>Tolak Resi</span>
                        </button>
                    </div>
                    <p class="text-[11px] text-slate-400 text-center leading-relaxed">
                        ⚡ <strong>Otomatisasi Stok:</strong> Memvalidasi pembayaran akan otomatis memotong kuantitas stok di database untuk seluruh item dalam pesanan ini.
                    </p>
                </form>
            </div>

            <!-- 2. Kitchen Status Flow -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="font-bold font-heading text-slate-900 text-base">Alur Proses Dapur</h3>
                    @php $oBadge = $pesanan->status_pesanan_badge; @endphp
                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-extrabold border {{ $oBadge['class'] }}">
                        {{ $oBadge['label'] }}
                    </span>
                </div>

                <form action="{{ route('admin.pesanan.updateStatus', $pesanan->id_pesanan) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="status_pesanan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Ubah Status Dapur:
                        </label>
                        <select name="status_pesanan" id="status_pesanan" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-bold text-slate-800 focus:ring-2 focus:ring-rose-500 outline-none">
                            <option value="menunggu_bayar" {{ $pesanan->status_pesanan === 'menunggu_bayar' ? 'selected' : '' }}>1. Menunggu Pembayaran</option>
                            <option value="diproses" {{ $pesanan->status_pesanan === 'diproses' ? 'selected' : '' }}>2. Sedang Dikukus / Siapkan Dapur</option>
                            <option value="siap_diambil" {{ $pesanan->status_pesanan === 'siap_diambil' ? 'selected' : '' }}>3. Siap Diambil / Panggil Ojol</option>
                            <option value="selesai" {{ $pesanan->status_pesanan === 'selesai' ? 'selected' : '' }}>4. Selesai & Diserahkan</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold shadow transition-colors flex items-center justify-center gap-2">
                        <i class="fa-solid fa-arrows-rotate"></i>
                        <span>Perbarui Status Dapur</span>
                    </button>
                </form>
            </div>

        </div>

        <!-- Right Column: Order Items & Customer Details -->
        <div class="lg:col-span-7 space-y-6">
            
            <!-- Items Detail Card -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <h3 class="text-lg font-bold font-heading text-slate-900">Rincian Menu Dipesan</h3>
                        <p class="text-xs text-slate-400">Dimsum & Varian Topping Tambahan</p>
                    </div>
                    <span class="text-xs font-bold text-rose-600 bg-rose-50 px-3 py-1 rounded-full">
                        {{ $pesanan->detailPesanan->count() }} Jenis Item
                    </span>
                </div>

                <div class="space-y-4 divide-y divide-slate-100">
                    @foreach($pesanan->detailPesanan as $detail)
                        <div class="pt-4 first:pt-0 flex justify-between items-start text-xs">
                            <div class="space-y-1">
                                <h4 class="font-extrabold text-sm text-slate-900">
                                    {{ $detail->menu ? $detail->menu->nama_menu : 'Menu Dimsum' }}
                                </h4>
                                <div class="text-[11px] text-rose-600 font-semibold flex items-center gap-2">
                                    <span>Topping: {{ $detail->topping ? $detail->topping->nama_topping : 'Original (Tanpa Topping)' }}</span>
                                    @if($detail->topping && $detail->topping->harga_tambahan > 0)
                                        <span class="text-slate-400">(+Rp {{ number_format($detail->topping->harga_tambahan, 0, ',', '.') }})</span>
                                    @endif
                                </div>
                                <p class="text-slate-400 text-[11px]">
                                    {{ $detail->jumlah }} porsi x Rp {{ number_format($detail->subtotal / $detail->jumlah, 0, ',', '.') }}
                                </p>
                            </div>

                            <span class="font-extrabold text-sm text-slate-900">
                                {{ $detail->formatted_subtotal }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <!-- Total Row -->
                <div class="pt-4 border-t border-dashed border-slate-200 flex justify-between items-center text-sm font-extrabold">
                    <span class="text-slate-900">TOTAL TRANSAKSI:</span>
                    <span class="text-2xl text-rose-600 font-heading">{{ $pesanan->formatted_total }}</span>
                </div>
            </div>

            <!-- Customer & Logistics Card -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-4">
                <h3 class="text-base font-bold font-heading text-slate-900 border-b border-slate-100 pb-3">
                    Informasi Pelanggan & Pengiriman
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-slate-400 block mb-0.5">Nama Pelanggan:</span>
                        <span class="font-bold text-slate-900 text-sm">{{ $pesanan->pelanggan ? $pesanan->pelanggan->nama : '-' }}</span>
                    </div>

                    <div>
                        <span class="text-slate-400 block mb-0.5">Nomor WhatsApp:</span>
                        <span class="font-bold text-slate-900">{{ $pesanan->pelanggan ? $pesanan->pelanggan->no_hp : '-' }}</span>
                    </div>

                    <div>
                        <span class="text-slate-400 block mb-0.5">Waktu Transaksi:</span>
                        <span class="font-medium text-slate-700">{{ $pesanan->tanggal_pesanan ? $pesanan->tanggal_pesanan->format('d/m/Y H:i:s') : '-' }}</span>
                    </div>

                    <div>
                        <span class="text-slate-400 block mb-0.5">Metode Pemenuhan:</span>
                        <span class="font-extrabold uppercase {{ $pesanan->metode_pengiriman === 'pickup' ? 'text-blue-600' : 'text-purple-600' }}">
                            {{ $pesanan->metode_pengiriman === 'pickup' ? 'Pickup (Ambil di Toko)' : 'Ojek Online Mandiri' }}
                        </span>
                    </div>
                </div>

                @if($pesanan->metode_pengiriman === 'ojol' && $pesanan->pelanggan && $pesanan->pelanggan->alamat)
                    <div class="pt-3 border-t border-slate-100 text-xs">
                        <span class="text-slate-400 block mb-0.5">Catatan Penjemputan / Alamat Ojol:</span>
                        <p class="bg-slate-50 p-3 rounded-xl border border-slate-200 text-slate-800 leading-relaxed font-medium">
                            {{ $pesanan->pelanggan->alamat }}
                        </p>
                    </div>
                @endif
            </div>

        </div>

    </div>

</div>

<!-- Modal: Zoom Bukti Pembayaran -->
<div id="image-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/80 backdrop-blur-md" onclick="closeImageModal()">
    <div class="relative max-w-2xl w-full bg-slate-950 p-2 rounded-2xl">
        <button type="button" onclick="closeImageModal()" class="absolute top-4 right-4 text-white bg-white/20 hover:bg-white/40 p-2 rounded-full text-sm">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <img id="modal-img-src" src="" alt="Zoom Bukti QRIS" class="max-h-[80vh] mx-auto rounded-xl object-contain">
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openImageModal(url) {
        document.getElementById('modal-img-src').src = url;
        document.getElementById('image-modal').classList.remove('hidden');
    }
    function closeImageModal() {
        document.getElementById('image-modal').classList.add('hidden');
    }
</script>
@endsection
