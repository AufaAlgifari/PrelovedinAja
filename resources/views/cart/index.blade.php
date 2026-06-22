@extends('layouts.app')

@section('content')
@if(session('error'))
<script>
    window.addEventListener('DOMContentLoaded', () => {
        window.showToast("{{ session('error') }}", 'error');
    });
</script>
@endif
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="border-b border-[#D4A017]/25 pb-5 mb-8 text-[#2E1A06]">
        <h1 class="text-3xl font-extrabold tracking-tight font-heading">Keranjang Belanja</h1>
        <p class="text-xs text-[#7A4A10] mt-1 font-medium">Lanjutkan ke halaman checkout untuk membeli barang preloved impian Anda.</p>
    </div>

    <!-- Main Cart Layout (Satu Kolom) -->
    <div id="cart-container" class="space-y-4">
        <!-- Left Side: Items List -->
        <div class="space-y-4" id="cart-items-list">
            <!-- Dynamically populated via JS -->
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

<script>
    let loadedCartItems = [];

    async function renderCart() {
        const token = localStorage.getItem('preloved_token');
        const container = document.getElementById('cart-container');
        const emptyState = document.getElementById('cart-empty-state');
        const itemsList = document.getElementById('cart-items-list');

        if (!token) {
            container.classList.add('hidden');
            emptyState.classList.remove('hidden');
            return;
        }

        try {
            const response = await fetch('/api/v1/cart', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });

            if (!response.ok) {
                throw new Error('Gagal mengambil data keranjang');
            }

            // Tampilkan notifikasi jika ada produk yang terhapus karena sudah terjual
            const removedHeader = response.headers.get('X-Removed-Items');
            if (removedHeader) {
                try {
                    const removedTitles = JSON.parse(removedHeader);
                    if (removedTitles && removedTitles.length > 0) {
                        removedTitles.forEach(title => {
                            window.showToast(`Produk "${title}" sudah terjual dan dihapus dari keranjang Anda.`, 'error');
                        });
                    }
                } catch (e) {
                    console.error('Gagal memproses data produk terhapus:', e);
                }
            }

            loadedCartItems = await response.json();

            if (loadedCartItems.length === 0) {
                container.classList.add('hidden');
                emptyState.classList.remove('hidden');
                return;
            }

            container.classList.remove('hidden');
            emptyState.classList.add('hidden');
            itemsList.innerHTML = '';

            loadedCartItems.forEach(item => {
                const product = item.product;
                if (!product) return;

                const itemPrice = parseInt(product.price);
                const priceFormatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(itemPrice);

                const image = product.image_urls && product.image_urls.length > 0 
                    ? product.image_urls[0] 
                    : 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80';
                
                const sellerName = product.seller ? product.seller.name : 'Mahasiswa Unsoed';
                const isAvailable = product.status === 'Available';

                const row = document.createElement('div');
                row.className = "bg-[#F5E4B0] p-5 rounded-3xl border border-[#D4A017]/25 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4 card-premium";
                
                // Buat Tombol Checkout Jika Available
                const checkoutBtnHTML = isAvailable 
                    ? `<a href="/checkout/${product.id}" class="px-5 py-2.5 bg-[#7A4A10] hover:bg-[#5f390c] text-[#FBF6EC] text-[10px] font-bold uppercase tracking-wider rounded-xl transition transform hover:-translate-y-0.5 whitespace-nowrap shadow-sm">⚡ Checkout</a>`
                    : `<span class="px-5 py-2.5 bg-gray-300 text-gray-500 text-[10px] font-bold uppercase tracking-wider rounded-xl cursor-not-allowed whitespace-nowrap">Tidak Tersedia</span>`;

                row.innerHTML = `
                    <div class="flex items-center gap-4 w-full sm:w-auto text-[#2E1A06]">
                        <img src="${image}" alt="${product.title}" class="w-20 h-20 rounded-2xl object-cover border border-[#D4A017]/20 bg-[#FBF6EC] flex-shrink-0">
                        <div>
                            <span class="text-[9px] text-[#7A4A10] font-bold uppercase tracking-wider block mb-1">👤 Penjual: ${sellerName}</span>
                            <a href="/products/${product.id}" class="font-extrabold text-[#2E1A06] text-sm hover:text-[#7A4A10] transition max-w-sm line-clamp-1 font-heading">${product.title}</a>
                            <p class="text-sm font-black text-[#7A4A10] mt-1">${priceFormatted}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between sm:justify-end gap-3 w-full sm:w-auto border-t border-[#D4A017]/10 sm:border-t-0 pt-3 sm:pt-0">
                        ${checkoutBtnHTML}
                        <button onclick="deleteItem(${item.id})" class="text-rose-600 hover:text-rose-800 hover:bg-rose-50 p-2.5 rounded-xl transition-all flex items-center justify-center" title="Hapus dari Keranjang">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                `;
                itemsList.appendChild(row);
            });

        } catch (error) {
            console.error('Error rendering cart:', error);
            container.classList.add('hidden');
            emptyState.classList.remove('hidden');
        }
    }

    async function deleteItem(cartId) {
        await window.removeFromCart(cartId);
        await renderCart();
    }

    window.addEventListener('DOMContentLoaded', () => {
        renderCart();
    });
</script>
@endsection