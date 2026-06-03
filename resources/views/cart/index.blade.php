@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="border-b border-slate-100 pb-5 mb-8">
        <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Keranjang Belanja</h1>
        <p class="text-xs text-slate-400 mt-1">Selesaikan pembelian barang preloved dari sesama mahasiswa UNSOED.</p>
    </div>

    <!-- Main Cart Layout -->
    <div id="cart-container" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Side: Items List -->
        <div class="lg:col-span-2 space-y-4" id="cart-items-list">
            <!-- Dynamically populated via JS -->
        </div>

        <!-- Right Side: Order Summary -->
        <div class="space-y-4">
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-xl shadow-slate-100/30 h-fit space-y-6">
                <h3 class="text-md font-bold text-slate-800 border-b border-slate-50 pb-3">Ringkasan Pembayaran</h3>
                
                <div class="space-y-3 text-xs text-slate-500">
                    <div class="flex justify-between">
                        <span>Subtotal Barang</span>
                        <span id="summary-subtotal" class="font-bold text-slate-700">Rp 0</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Biaya Layanan COD Kampus</span>
                        <span class="font-bold text-brand-600 bg-brand-50 px-2 py-0.5 rounded-full border border-brand-100">Gratis (COD)</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Biaya Administrasi</span>
                        <span class="font-bold text-slate-700">Rp 0</span>
                    </div>
                </div>

                <div class="border-t border-slate-50 pt-4 flex justify-between items-baseline">
                    <span class="text-xs font-bold text-slate-500 uppercase">Total Pembayaran</span>
                    <span id="summary-total" class="text-2xl font-black text-brand-600">Rp 0</span>
                </div>
                
                <button onclick="triggerCheckout()" class="w-full text-slate-900 btn-gradient py-4 rounded-2xl font-bold text-xs uppercase tracking-wider shadow-lg shadow-brand-500/20 transition transform hover:-translate-y-0.5 text-center flex items-center justify-center gap-2">
                    ✅ Checkout Sekarang
                </button>
            </div>
            
            <div class="bg-brand-50/30 border border-brand-100/50 rounded-2xl p-4 text-[11px] text-brand-900 leading-relaxed">
                ℹ️ <strong>Tips Transaksi Safe COD:</strong> Temui penjual di area publik kampus yang ramai (seperti Perpustakaan Pusat, Gazebo, atau GOR). Periksa kondisi fisik barang secara teliti sebelum menyerahkan uang pembayaran.
            </div>
        </div>
    </div>

    <!-- Empty State -->
    <div id="cart-empty-state" class="hidden py-24 text-center bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-100/30 max-w-xl mx-auto p-8">
        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300 text-3xl">🛒</div>
        <h2 class="text-xl font-bold text-slate-800">Keranjang belanja Anda kosong</h2>
        <p class="text-xs text-slate-400 mt-2 max-w-sm mx-auto leading-relaxed">Anda belum menambahkan barang preloved mahasiswa ke dalam keranjang. Mulai cari buku kuliah atau gadget menarik sekarang!</p>
        <div class="mt-8">
            <a href="{{ route('home') }}" class="inline-flex px-6 py-3.5 bg-brand-500 hover:bg-brand-600 text-slate-900 font-bold text-xs rounded-xl shadow-md transition transform hover:-translate-y-0.5">
                🛍️ Jelajahi Katalog Barang
            </a>
        </div>
    </div>
</div>

<!-- Checkout Success Modal -->
<div id="checkout-modal" class="hidden fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
    <div class="bg-white rounded-3xl border border-slate-100 max-w-md w-full p-8 shadow-2xl relative overflow-hidden transform scale-95 transition-all text-center space-y-6">
        <!-- Confetti/Success Graphic -->
        <div class="inline-flex items-center justify-center p-4 bg-brand-50 text-brand-750 rounded-full border border-brand-100 mx-auto">
            <svg class="w-12 h-12 animate-bounce text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>

        <div class="space-y-2">
            <h3 class="text-2xl font-black text-slate-800">Pemesanan Sukses!</h3>
            <p class="text-xs text-slate-500 leading-relaxed">Pesanan Anda telah berhasil dibuat dengan sistem <strong>COD Kampus</strong>. Detail invoice telah diteruskan ke pihak penjual.</p>
        </div>

        <!-- Order Detail Summary Card -->
        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-100 text-left space-y-2 text-xs">
            <div class="flex justify-between"><span class="text-slate-400">ID Transaksi:</span><strong class="text-slate-700" id="modal-trx-id">TRX-XXXXXX</strong></div>
            <div class="flex justify-between"><span class="text-slate-400">Metode Pembayaran:</span><strong class="text-slate-700">COD (Bayar di Tempat)</strong></div>
            <div class="flex justify-between"><span class="text-slate-400">Total Tagihan:</span><strong class="text-brand-600 font-extrabold" id="modal-total-price">Rp 0</strong></div>
            <div class="flex justify-between"><span class="text-slate-400">Status Pembelian:</span><span class="bg-brand-50 text-brand-850 font-bold px-2 py-0.5 rounded-full border border-brand-200 text-[10px] uppercase">Diproses</span></div>
        </div>

        <div class="pt-4 flex flex-col gap-2">
            <a href="{{ route('transactions.history') }}" class="w-full text-slate-900 btn-gradient py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider shadow-md transition transform hover:-translate-y-0.5">
                📦 Lihat Riwayat Transaksi
            </a>
            <button onclick="closeCheckoutModal()" class="w-full py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
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
            const totalItemPrice = itemPrice * item.quantity;
            subtotal += totalItemPrice;

            const priceFormatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(itemPrice);

            const row = document.createElement('div');
            row.className = "bg-white p-5 rounded-3xl border border-slate-100/80 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4 card-premium";
            row.innerHTML = `
                <div class="flex items-center gap-4 w-full sm:w-auto">
                    <img src="${item.image}" alt="${item.title}" class="w-20 h-20 rounded-2xl object-cover border border-slate-100 bg-slate-50 flex-shrink-0">
                    <div>
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1">👤 Penjual: ${item.seller}</span>
                        <h4 class="font-bold text-slate-800 text-sm hover:text-brand-600 transition max-w-sm line-clamp-1">${item.title}</h4>
                        <p class="text-sm font-extrabold text-brand-600 mt-1">${priceFormatted}</p>
                    </div>
                </div>
                
                <!-- Quantity & Delete -->
                <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto border-t sm:border-t-0 pt-3 sm:pt-0">
                    <div class="flex items-center border border-slate-100 bg-slate-50 rounded-xl p-1">
                        <button onclick="changeQty(${item.id}, -1)" class="w-8 h-8 flex items-center justify-center text-slate-500 hover:text-brand-600 font-bold focus:outline-none transition rounded-lg hover:bg-white">-</button>
                        <span class="px-3 text-xs font-extrabold text-slate-800">${item.quantity}</span>
                        <button onclick="changeQty(${item.id}, 1)" class="w-8 h-8 flex items-center justify-center text-slate-500 hover:text-brand-600 font-bold focus:outline-none transition rounded-lg hover:bg-white">+</button>
                    </div>
                    
                    <button onclick="deleteItem(${item.id})" class="text-rose-500 hover:text-rose-700 hover:bg-rose-50 p-2.5 rounded-xl transition-all flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            `;
            itemsList.appendChild(row);
        });

        // Set summary
        const subtotalFormatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(subtotal);
        document.getElementById('summary-subtotal').textContent = subtotalFormatted;
        document.getElementById('summary-total').textContent = subtotalFormatted;
    }

    function changeQty(productId, delta) {
        const cart = window.getCart();
        const item = cart.find(item => item.id == productId);
        if(item) {
            item.quantity += delta;
            if(item.quantity <= 0) {
                deleteItem(productId);
                return;
            }
            localStorage.setItem('preloved_cart', JSON.stringify(cart));
            window.updateCartBadge();
            renderCart();
        }
    }

    function deleteItem(productId) {
        window.removeFromCart(productId);
        window.showToast('Item berhasil dihapus dari keranjang.');
        renderCart();
    }

    function triggerCheckout() {
        const user = localStorage.getItem('preloved_user');
        if(!user) {
            window.showToast('Silakan login terlebih dahulu untuk checkout.', 'error');
            setTimeout(() => {
                window.location.href = "{{ route('login') }}";
            }, 1000);
            return;
        }

        const cart = window.getCart();
        let total = cart.reduce((sum, item) => sum + (parseInt(item.price) * item.quantity), 0);
        const totalFormatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(total);

        // Generate mock transaction ID
        const trxId = 'TRX-' + Math.floor(Math.random() * 900000 + 100000);
        
        // Save items to transactions history in localStorage
        let transactions = JSON.parse(localStorage.getItem('preloved_transactions') || '[]');
        cart.forEach(item => {
            transactions.unshift({
                id: trxId,
                title: item.title,
                method: 'COD (Fakultas Penjual)',
                price: item.price,
                status: 'Completed',
                image: item.image,
                hasReviewed: false
            });
        });
        localStorage.setItem('preloved_transactions', JSON.stringify(transactions));

        document.getElementById('modal-trx-id').textContent = trxId;
        document.getElementById('modal-total-price').textContent = totalFormatted;

        // Clear cart
        localStorage.removeItem('preloved_cart');
        window.updateCartBadge();

        // Show Modal
        const modal = document.getElementById('checkout-modal');
        modal.classList.remove('hidden');
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