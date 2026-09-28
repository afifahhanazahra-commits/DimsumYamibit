@extends('layouts.app')

@section('title', 'Checkout & Pembayaran QRIS - Dimsum Yamibit')

@section('content')
<div class="py-12 bg-slate-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Breadcrumb -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <a href="{{ route('home') }}" class="text-xs font-bold text-rose-600 hover:text-rose-700 inline-flex items-center gap-1.5 mb-2">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Katalog Menu
                </a>
                <h1 class="text-2xl sm:text-3xl font-extrabold font-heading text-gray-900">
                    Form Pemesanan & Pembayaran QRIS
                </h1>
                <p class="text-xs text-gray-500 mt-1">Lengkapi identitas Anda dan lakukan pembayaran untuk konfirmasi pesanan.</p>
            </div>
            <div class="hidden sm:block">
                <span class="bg-rose-100 text-rose-700 text-xs font-extrabold px-3 py-1 rounded-full">
                    🥟 Dimsum Yamibit
                </span>
            </div>
        </div>

        @if(isset($storeStatus) && !$storeStatus['is_open'])
            <div class="mb-8 bg-amber-500/10 border-2 border-amber-500/40 rounded-3xl p-5 flex flex-col sm:flex-row items-center gap-4 text-amber-950 shadow-sm">
                <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-xl flex-shrink-0 shadow-md">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <div class="text-center sm:text-left flex-1">
                    <div class="flex items-center justify-center sm:justify-start gap-2">
                        <span class="bg-amber-500 text-white text-[10px] font-extrabold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                            {{ $storeStatus['status_label'] }}
                        </span>
                        <h3 class="font-extrabold text-sm sm:text-base text-amber-950">Fitur Pemesanan Sedang Ditutup</h3>
                    </div>
                    <p class="text-xs sm:text-sm text-amber-900/90 mt-1">
                        Jam operasional Dimsum Yamibit: <strong>Selasa – Minggu, pukul 14.30 – 21.00 WIB</strong> (Senin Libur). Pengiriman formulir pemesanan dinonaktifkan di luar jam buka.
                    </p>
                </div>
            </div>
        @endif

        <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data" id="checkout-form" class="space-y-8">
            @csrf

            <!-- Hidden container for cart items input -->
            <div id="hidden-cart-inputs"></div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <!-- Left Column: Customer Details & Delivery -->
                <div class="lg:col-span-7 space-y-6">
                    
                    <!-- Section 1: Data Pemesan -->
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-200/80 shadow-sm space-y-5">
                        <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                            <div class="w-8 h-8 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center font-bold text-sm">
                                1
                            </div>
                            <h2 class="text-lg font-bold font-heading text-gray-900">Identitas Pemesan</h2>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label for="nama" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                                    Nama Lengkap <span class="text-rose-600">*</span>
                                </label>
                                <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required placeholder="Contoh: Budi Santoso" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-rose-500 focus:ring-2 focus:ring-rose-200 outline-none text-sm font-medium transition-all">
                                @error('nama')
                                    <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="no_hp" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                                    Nomor WhatsApp Aktif <span class="text-rose-600">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 text-sm font-bold">
                                        <i class="fa-brands fa-whatsapp text-emerald-500 text-base mr-1"></i>
                                    </span>
                                    <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" required placeholder="08xxxxxxxxxx" class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-300 focus:border-rose-500 focus:ring-2 focus:ring-rose-200 outline-none text-sm font-medium transition-all">
                                </div>
                                <p class="text-[11px] text-gray-400 mt-1">Nomor ini digunakan pengelola untuk konfirmasi kesiapan pesanan.</p>
                                @error('no_hp')
                                    <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Metode Pemenuhan Pesanan -->
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-200/80 shadow-sm space-y-5">
                        <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                            <div class="w-8 h-8 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center font-bold text-sm">
                                2
                            </div>
                            <h2 class="text-lg font-bold font-heading text-gray-900">Metode Pengambilan / Pengiriman</h2>
                        </div>

                        <div class="space-y-3">
                            <label class="flex items-start gap-4 p-4 rounded-2xl border-2 border-gray-200 hover:border-rose-300 cursor-pointer bg-gray-50/50 has-[:checked]:bg-rose-50/70 has-[:checked]:border-rose-500 transition-all">
                                <input type="radio" name="metode_pengiriman" value="pickup" checked onchange="toggleAlamatField()" class="mt-1 text-rose-600 focus:ring-rose-500 w-4 h-4">
                                <div>
                                    <span class="block text-sm font-bold text-gray-900">
                                        <i class="fa-solid fa-store text-rose-600 mr-1.5"></i> Pickup (Ambil Sendiri di Toko)
                                    </span>
                                    <span class="block text-xs text-gray-500 mt-0.5">
                                        Ambil langsung pesanan di Outlet Talun, Cirebon setelah pesanan siap.
                                    </span>
                                </div>
                            </label>

                            <label class="flex items-start gap-4 p-4 rounded-2xl border-2 border-gray-200 hover:border-rose-300 cursor-pointer bg-gray-50/50 has-[:checked]:bg-rose-50/70 has-[:checked]:border-rose-500 transition-all">
                                <input type="radio" name="metode_pengiriman" value="ojol" onchange="toggleAlamatField()" class="mt-1 text-rose-600 focus:ring-rose-500 w-4 h-4">
                                <div>
                                    <span class="block text-sm font-bold text-gray-900">
                                        <i class="fa-solid fa-motorcycle text-rose-600 mr-1.5"></i> Pesan Ojek Online Mandiri
                                    </span>
                                    <span class="block text-xs text-gray-500 mt-0.5">
                                        Pelanggan memesan kurir GrabExpress / GoSend / Maxim mandiri untuk mengambil di outlet.
                                    </span>
                                </div>
                            </label>
                        </div>

                        <div id="alamat-wrapper" class="hidden space-y-1.5 pt-2">
                            <label for="alamat" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Catatan Pengiriman / Alamat Penjemputan Ojol
                            </label>
                            <textarea name="alamat" id="alamat" rows="2" placeholder="Tuliskan catatan penjemputan ojol atau alamat tujuan..." class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:border-rose-500 focus:ring-2 focus:ring-rose-200 outline-none text-sm">{{ old('alamat') }}</textarea>
                        </div>
                    </div>

                    <!-- Section 3: Pembayaran QRIS & Bukti Transfer -->
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-200/80 shadow-sm space-y-5">
                        <div class="flex items-center gap-3 border-b border-gray-100 pb-4">
                            <div class="w-8 h-8 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center font-bold text-sm">
                                3
                            </div>
                            <h2 class="text-lg font-bold font-heading text-gray-900">Pembayaran QRIS Statis Toko</h2>
                        </div>

                        <!-- QRIS Card Template -->
                        <div class="bg-gradient-to-br from-slate-900 to-rose-950 text-white rounded-2xl p-6 shadow-md border border-white/10 space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-qrcode text-amber-400 text-2xl"></i>
                                    <span class="font-extrabold font-heading tracking-wide text-lg text-white">QRIS DIMSUM YAMIBIT</span>
                                </div>
                                <span class="bg-white/20 text-amber-300 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">
                                    NMID: ID1020268899074
                                </span>
                            </div>

                            <!-- QR Code Visual Box -->
                             <div class="bg-white p-3 rounded-xl max-w-[240px] mx-auto text-slate-900 text-center shadow-inner">
                                 <img src="{{ asset('images/qris.jpg') }}"
                                      alt="QRIS Dimsum Yamibit"
                                      class="w-full rounded-lg">
                                 <span class="block text-[11px] font-extrabold text-slate-800 mt-2">Scan Semua E-Wallet &amp; Bank</span>
                                 <span class="block text-[10px] text-gray-500">GoPay, OVO, ShopeePay, Dana, BCA, BRI, Mandiri</span>
                             </div>

                            <!-- Alternative Bank Accounts -->
                            <div class="text-xs text-gray-300 pt-2 border-t border-white/10 space-y-1">
                                <p class="font-bold text-amber-300">Alternatif Transfer Bank Manual:</p>
                                <p>• <strong>BCA:</strong> 1234567890 a.n. Dimsum Yamibit</p>
                                <p>• <strong>DANA / SPay:</strong> 08990745953</p>
                            </div>
                        </div>

                        <!-- Upload Bukti Transfer -->
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Unggah Bukti Pembayaran QRIS / Transfer <span class="text-rose-600">*</span>
                            </label>
                            
                            <div class="border-2 border-dashed border-gray-300 hover:border-rose-400 rounded-2xl p-4 text-center bg-gray-50/50 transition-all cursor-pointer relative" onclick="document.getElementById('bukti_qris').click()">
                                <input type="file" name="bukti_qris" id="bukti_qris" accept="image/*" required class="hidden" onchange="previewReceiptImage(event)">
                                
                                <div id="preview-placeholder" class="py-4 space-y-2">
                                    <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto text-xl">
                                        <i class="fa-solid fa-cloud-arrow-up"></i>
                                    </div>
                                    <p class="text-xs font-bold text-gray-700">Klik untuk memilih foto bukti transfer</p>
                                    <p class="text-[11px] text-gray-400">Format: JPG, PNG, WebP (Maksimal 5MB)</p>
                                </div>

                                <div id="preview-container" class="hidden space-y-2 py-2">
                                    <img id="preview-image" src="" alt="Pratinjau Bukti" class="max-h-48 mx-auto rounded-xl shadow-md object-contain">
                                    <p class="text-xs text-emerald-600 font-bold flex items-center justify-center gap-1">
                                        <i class="fa-solid fa-circle-check"></i> Foto bukti siap diunggah (klik untuk ganti)
                                    </p>
                                </div>
                            </div>
                            @error('bukti_qris')
                                <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                </div>

                <!-- Right Column: Order Summary & Pay Action -->
                <div class="lg:col-span-5 space-y-6">
                    
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-200/80 shadow-sm sticky top-28 space-y-6">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                            <h3 class="text-lg font-bold font-heading text-gray-900">Ringkasan Pesanan</h3>
                            <span id="summary-total-qty" class="text-xs font-bold text-rose-600 bg-rose-50 px-2.5 py-1 rounded-full">0 porsi</span>
                        </div>

                        <!-- Dynamic Items List -->
                        <div id="checkout-items-list" class="space-y-3 max-h-72 overflow-y-auto pr-1">
                            <!-- Injected by JavaScript -->
                        </div>

                        <!-- Subtotal & Total Calculations -->
                        <div class="border-t border-gray-100 pt-4 space-y-2 text-sm">
                            <div class="flex justify-between text-gray-500">
                                <span>Subtotal Menu</span>
                                <span id="summary-subtotal" class="font-bold text-gray-800">Rp 0</span>
                            </div>
                            <div class="flex justify-between text-gray-500">
                                <span>Biaya Layanan Web</span>
                                <span class="font-bold text-emerald-600">Gratis (Rp 0)</span>
                            </div>
                            <div class="flex justify-between text-lg font-extrabold text-gray-900 border-t border-dashed border-gray-200 pt-3">
                                <span>Total Tagihan</span>
                                <span id="summary-total" class="font-heading text-2xl text-rose-600">Rp 0</span>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        @if(isset($storeStatus) && !$storeStatus['is_open'])
                            <button type="button" disabled class="w-full bg-slate-300 text-slate-500 py-4 px-6 rounded-2xl font-bold text-base cursor-not-allowed flex items-center justify-center gap-3">
                                <i class="fa-solid fa-lock"></i>
                                <span>Pemesanan Ditutup (Buka 14.30 - 21.00)</span>
                            </button>
                        @else
                            <button type="submit" id="btn-submit-order" class="w-full btn-gradient text-white py-4 px-6 rounded-2xl font-bold text-base shadow-xl flex items-center justify-center gap-3">
                                <i class="fa-solid fa-paper-plane"></i>
                                <span>Konfirmasi & Kirim Pesanan</span>
                            </button>
                        @endif

                        <p class="text-[11px] text-gray-400 text-center leading-relaxed">
                            🔒 Pesanan Anda akan diverifikasi oleh Admin. Stok akan dipotong otomatis setelah verifikasi pembayaran berhasil.
                        </p>
                    </div>

                </div>

            </div>
        </form>

    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleAlamatField() {
        const selected = document.querySelector('input[name="metode_pengiriman"]:checked').value;
        const wrapper = document.getElementById('alamat-wrapper');
        if (selected === 'ojol') {
            wrapper.classList.remove('hidden');
        } else {
            wrapper.classList.add('hidden');
        }
    }

    function previewReceiptImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
                document.getElementById('preview-placeholder').classList.add('hidden');
                document.getElementById('preview-container').classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    }

    function renderCheckoutItems() {
        const cart = getCart();
        const container = document.getElementById('checkout-items-list');
        const hiddenInputsContainer = document.getElementById('hidden-cart-inputs');
        const totalQtyBadge = document.getElementById('summary-total-qty');
        const subtotalEl = document.getElementById('summary-subtotal');
        const totalEl = document.getElementById('summary-total');
        const submitBtn = document.getElementById('btn-submit-order');

        if (!container) return;

        if (cart.length === 0) {
            container.innerHTML = `
                <div class="text-center py-8 text-gray-400">
                    <p class="font-bold text-sm text-gray-700">Keranjang Masih Kosong</p>
                    <a href="{{ route('home') }}#menu" class="text-xs text-rose-600 font-bold hover:underline mt-2 inline-block">
                        &larr; Pilih Menu Sekarang
                    </a>
                </div>
            `;
            submitBtn.classList.add('opacity-50', 'pointer-events-none');
            return;
        }

        submitBtn.classList.remove('opacity-50', 'pointer-events-none');

        let totalQty = 0;
        let totalPrice = 0;
        let html = '';
        let hiddenHtml = '';

        cart.forEach((item, index) => {
            const itemPrice = parseInt(item.price) + (parseInt(item.toppingPrice) || 0);
            const subtotal = itemPrice * item.qty;
            totalQty += item.qty;
            totalPrice += subtotal;

            html += `
                <div class="flex justify-between items-start py-2 border-b border-gray-100 text-xs">
                    <div>
                        <p class="font-bold text-gray-900 text-sm">${item.name}</p>
                        <p class="text-rose-600 font-medium">
                            ${item.toppingName ? `+ Topping ${item.toppingName}` : 'Original'}
                        </p>
                        <p class="text-gray-400 text-[11px]">${item.qty} x Rp ${itemPrice.toLocaleString('id-ID')}</p>
                    </div>
                    <span class="font-bold text-gray-800 text-sm">Rp ${subtotal.toLocaleString('id-ID')}</span>
                </div>
            `;

            // Hidden input for POST request
            hiddenHtml += `
                <input type="hidden" name="items[${index}][id_menu]" value="${item.id_menu}">
                <input type="hidden" name="items[${index}][id_topping]" value="${item.id_topping || ''}">
                <input type="hidden" name="items[${index}][jumlah]" value="${item.qty}">
            `;
        });

        container.innerHTML = html;
        hiddenInputsContainer.innerHTML = hiddenHtml;
        totalQtyBadge.innerText = `${totalQty} porsi`;
        subtotalEl.innerText = `Rp ${totalPrice.toLocaleString('id-ID')}`;
        totalEl.innerText = `Rp ${totalPrice.toLocaleString('id-ID')}`;
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderCheckoutItems();
    });
</script>
@endsection
