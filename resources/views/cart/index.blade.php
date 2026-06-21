@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="border-b border-[#D4A017]/25 pb-5 mb-8 text-[#2E1A06]">
        <h1 class="text-3xl font-extrabold tracking-tight font-heading">Keranjang Belanja</h1>
        <p class="text-xs text-[#7A4A10] mt-1 font-medium">Selesaikan pembelian barang preloved dari sesama mahasiswa UNSOED.</p>
    </div>

    <!-- Main Cart Layout -->
    <div id="cart-container" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Side: Items List -->
        <div class="lg:col-span-2 space-y-4" id="cart-items-list">
            <!-- Dynamically populated via JS -->
        </div>

        <!-- Right Side: Order Summary -->
        <div class="space-y-4 text-[#2E1A06]">
            <div class="bg-[#F5E4B0] p-6 rounded-3xl border border-[#D4A017]/25 shadow-xl space-y-6">
                <h3 class="text-md font-bold border-b border-[#D4A017]/10 pb-3 font-heading">Ringkasan Pesanan</h3>
                
                <div class="space-y-4 text-xs text-[#2E1A06]/85 font-medium">
                    <div class="flex justify-between">
                        <span id="summary-item-count">Total Harga (0 Barang)</span>
                        <span id="summary-subtotal" class="font-bold text-[#2E1A06]">Rp 0</span>
                    </div>
                    
                    <div class="border-t border-[#D4A017]/15 pt-4 flex justify-between items-baseline">
                        <span class="text-xs font-black text-[#2E1A06] uppercase tracking-wider">Total Belanja</span>
                        <span id="summary-total" class="text-2xl font-black text-[#7A4A10]">Rp 0</span>
                    </div>
                </div>

                <div class="space-y-3">
                    <button onclick="triggerCheckout()" class="w-full text-[#FBF6EC] bg-[#7A4A10] hover:bg-[#5f390c] py-4 rounded-2xl font-bold text-xs uppercase tracking-wider shadow-lg transition transform hover:-translate-y-0.5 text-center flex items-center justify-center gap-2">
                        Lanjut Pembayaran
                    </button>
                    <p class="text-[10px] text-center text-[#7A4A10] font-medium leading-relaxed">
                        Selesaikan transaksi dengan COD di lingkungan kampus demi keamanan bersama. Biaya COD & Layanan: <strong>Gratis</strong>
                    </p>
                </div>
            </div>
            
            <div class="bg-[#F5E4B0]/40 border border-[#D4A017]/20 rounded-2xl p-4 text-[11px] text-[#2E1A06]/90 leading-relaxed font-medium">
                ℹ️ <strong>Tips Transaksi Safe COD:</strong> Temui penjual di area publik kampus yang ramai (seperti Perpustakaan Pusat, Gazebo, atau GOR). Periksa kondisi fisik barang secara teliti sebelum menyerahkan uang pembayaran.
            </div>
        </div>
    </div>

    <!-- Empty State -->
    <div id="cart-empty-state" class="hidden py-24 text-center bg-[#F5E4B0] rounded-3xl border border-[#D4A017]/25 shadow-xl max-w-xl mx-auto p-8 text-[#2E1A06]">
        <div class="w-20 h-20 bg-[#FBF6EC] rounded-full flex items-center justify-center mx-auto mb-6 text-[#7A4A10] text-3xl">🛒</div>
        <h2 class="text-xl font-bold font-heading">Keranjang belanja Anda kosong</h2>
        <p class="text-xs text-[#7A4A10] mt-2 max-w-sm mx-auto leading-relaxed">Anda belum menambahkan barang preloved mahasiswa ke dalam keranjang. Mulai cari buku kuliah atau gadget menarik sekarang!</p>
        <div class="mt-8">
            <a href="{{ route('home') }}" class="inline-flex px-6 py-3.5 bg-[#7A4A10] hover:bg-[#5f390c] text-[#FBF6EC] font-bold text-xs rounded-xl shadow-md transition transform hover:-translate-y-0.5">
                🛍️ Jelajahi Katalog Barang
            </a>
        </div>
    </div>
</div>

<!-- Checkout Success Modal -->
<div id="checkout-modal" class="hidden fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-[#2E1A06]/60 backdrop-blur-sm">
    <div class="bg-[#F5E4B0] rounded-3xl border border-[#D4A017]/25 max-w-md w-full p-8 shadow-2xl relative overflow-hidden transform scale-95 transition-all text-center space-y-6 text-[#2E1A06]">
        <!-- Success Graphic -->
        <div class="inline-flex items-center justify-center p-4 bg-[#FBF6EC] text-[#7A4A10] rounded-full border border-[#D4A017]/20 mx-auto">
            <svg class="w-12 h-12 animate-bounce text-[#7A4A10]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>

        <div class="space-y-2">
            <h3 class="text-2xl font-black font-heading text-[#2E1A06]">Pemesanan Sukses!</h3>
            <p class="text-xs text-[#7A4A10] leading-relaxed">Pesanan Anda telah berhasil dibuat dengan sistem <strong>COD Kampus</strong>. Detail invoice telah diteruskan ke pihak penjual.</p>
        </div>

        <!-- Order Detail Summary Card -->
        <div class="bg-[#FBF6EC] p-5 rounded-2xl border border-[#D4A017]/25 text-left space-y-2 text-xs">
            <div class="flex justify-between"><span class="text-[#7A4A10] font-medium">ID Transaksi:</span><strong class="text-[#2E1A06]" id="modal-trx-id">TRX-XXXXXX</strong></div>
            <div class="flex justify-between"><span class="text-[#7A4A10] font-medium">Metode Pembayaran:</span><strong class="text-[#2E1A06]">COD (Bayar di Tempat)</strong></div>
            <div class="flex justify-between"><span class="text-[#7A4A10] font-medium">Total Tagihan:</span><strong class="text-[#7A4A10] font-black" id="modal-total-price">Rp 0</strong></div>
            <div class="flex justify-between"><span class="text-[#7A4A10] font-medium">Status Pembelian:</span><span class="bg-[#7A4A10] text-[#FBF6EC] font-extrabold px-2.5 py-0.5 rounded-full text-[9px] uppercase border border-[#7A4A10]">Diproses</span></div>
        </div>

        <div class="pt-4 flex flex-col gap-2">
            <a href="{{ route('transactions.history') }}" class="w-full text-[#FBF6EC] bg-[#7A4A10] hover:bg-[#5f390c] py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider shadow-md transition transform hover:-translate-y-0.5 text-center">
                📦 Lihat Riwayat Transaksi
            </a>
            <button onclick="closeCheckoutModal()" class="w-full py-3 bg-[#FBF6EC] hover:bg-[#F5E4B0] text-[#7A4A10] text-xs font-bold rounded-xl border border-[#D4A017]/30 transition">
                Belanja Lagi
            </button>
        </div>
    </div>
</div>

<script>
    function renderCart() {
        const cart = window.getCart();
        const container = document.getElementById('cart-container');
        const emptyState = document.getElementById('cart-empty-state');
        const itemsList = document.getElementById('cart-items-list');

        if(cart.length === 0) {
            container.classList.add('hidden');
            emptyState.classList.remove('hidden');
            return;
        }

        container.classList.remove('hidden');
        emptyState.classList.add('hidden');
        itemsList.innerHTML = '';

        let subtotal = 0;

        cart.forEach(item => {
            const itemPrice = parseInt(item.price);
            subtotal += itemPrice;

            const priceFormatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(itemPrice);

            let displayCond = item.condition || 'Bekas';
            if (displayCond === 'New' || displayCond === 'Like New') displayCond = 'Baru';
            else if (displayCond === 'Good') displayCond = 'Bekas';
            else if (displayCond === 'Well Used') displayCond = 'Usang';

            let condBadgeClass = 'bg-gray-100 text-gray-500 border-gray-300';
            if (displayCond === 'Baru') condBadgeClass = 'bg-green-100 text-green-700 border-green-300';
            else if (displayCond === 'Bekas') condBadgeClass = 'bg-amber-100 text-amber-700 border-amber-300';

            const sellerFaculty = item.seller_faculty ? item.seller_faculty.toUpperCase() : 'FT';

            const card = document.createElement('div');
            card.className = "bg-[#F5E4B0] p-5 rounded-3xl border border-[#D4A017]/25 shadow-sm flex gap-4 relative text-[#2E1A06] card-premium";
            
            card.innerHTML = `
                <img src="${item.image}" alt="${item.title}" class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl object-cover border border-[#D4A017]/20 bg-[#FBF6EC] flex-shrink-0">
                <div class="flex-1 flex flex-col justify-between min-w-0">
                    <div>
                        <!-- Title & Delete Button Container -->
                        <div class="flex justify-between items-start gap-4">
                            <h4 class="font-extrabold text-[#2E1A06] text-sm sm:text-base hover:text-[#7A4A10] transition line-clamp-2 font-heading">${item.title}</h4>
                            <button onclick="deleteItem(${item.id})" class="text-rose-600 hover:text-rose-800 hover:bg-rose-50 p-2 rounded-xl transition-all shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Badges -->
                        <div class="flex flex-wrap gap-2 mt-1.5">
                            <span class="px-2 py-0.5 border rounded-full text-[9px] font-extrabold uppercase ${condBadgeClass}">${displayCond}</span>
                            <span class="px-2 py-0.5 border border-[#D4A017]/30 bg-[#FBF6EC]/60 text-[#7A4A10] text-[9px] font-extrabold rounded-full flex items-center gap-1">📍 ${sellerFaculty} UNSOED</span>
                        </div>
                    </div>

                    <!-- Price & Chat Button -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mt-4 pt-3 border-t border-[#D4A017]/10">
                        <p class="text-sm sm:text-base font-black text-[#7A4A10]">${priceFormatted}</p>
                        <a href="{{ route('chat.index') }}?seller_id=${item.seller_id || 1}&product_id=${item.id}" class="bg-[#7A4A10] hover:bg-[#5f390c] text-[#FBF6EC] px-4 py-2 rounded-xl font-bold text-[10px] sm:text-xs uppercase tracking-wider shadow-sm transition flex items-center justify-center gap-1.5 w-full sm:w-auto text-center font-semibold">
                            💬 Chat Penjual
                        </a>
                    </div>
                </div>
            `;
            itemsList.appendChild(card);
        });

        // Set summary
        const subtotalFormatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(subtotal);
        document.getElementById('summary-subtotal').textContent = subtotalFormatted;
        document.getElementById('summary-total').textContent = subtotalFormatted;
        document.getElementById('summary-item-count').textContent = `Total Harga (${cart.length} Barang)`;
    }

    function deleteItem(productId) {
        window.removeFromCart(productId);
        window.showToast('Item berhasil dihapus dari keranjang.');
        renderCart();
    }

    async function triggerCheckout() {
        const user = localStorage.getItem('preloved_user');
        const token = localStorage.getItem('preloved_token');
        if(!user || !token) {
            window.showToast('Silakan login terlebih dahulu untuk checkout.', 'error');
            setTimeout(() => {
                window.location.href = "{{ route('login') }}";
            }, 1000);
            return;
        }

        const cart = window.getCart();
        if (cart.length === 0) {
            window.showToast('Keranjang belanja Anda kosong.', 'error');
            return;
        }

        // Untuk Phase 1, kita arahkan ke halaman checkout produk pertama di cart atau mock
        // Karena spec minta checkout/{product}, kita ambil item pertama saja sebagai contoh
        window.location.href = `/checkout/${cart[0].id}`;
    }

    function closeCheckoutModal() {
        document.getElementById('checkout-modal').classList.add('hidden');
        window.location.href = "{{ route('home') }}";
    }

    window.addEventListener('DOMContentLoaded', () => {
        renderCart();
    });
</script>
@endsection