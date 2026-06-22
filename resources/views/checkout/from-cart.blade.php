@extends('layouts.app')

@section('head')
<script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-[#2E1A06]">
    <div class="border-b border-[#D4A017]/25 pb-5 mb-8">
        <h1 class="text-3xl font-extrabold tracking-tight font-heading">Konfirmasi Pembayaran</h1>
        <p class="text-xs text-[#7A4A10] mt-1 font-medium">Periksa kembali pesanan Anda sebelum melanjutkan pembayaran.</p>
    </div>

    <div id="loading-state" class="text-center py-12">
        <p class="text-sm text-[#7A4A10]">Memuat data keranjang...</p>
    </div>

    <div id="checkout-content" class="hidden">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-4">
                <div class="bg-[#F5E4B0] p-6 rounded-3xl border border-[#D4A017]/25 shadow-xl">
                    <h3 class="text-md font-bold border-b border-[#D4A017]/10 pb-3 mb-4 font-heading">Barang yang Dibeli</h3>
                    <div id="items-list" class="space-y-4">
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div class="bg-[#F5E4B0] p-6 rounded-3xl border border-[#D4A017]/25 shadow-xl space-y-6">
                    <h3 class="text-md font-bold border-b border-[#D4A017]/10 pb-3 font-heading">Ringkasan Pembayaran</h3>
                    
                    <div class="space-y-3 text-xs text-[#2E1A06]/80 font-medium">
                        <div class="flex justify-between">
                            <span>Subtotal Barang</span>
                            <span id="summary-subtotal" class="font-bold text-[#2E1A06]">Rp 0</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Metode Pengiriman</span>
                            <span id="summary-method" class="font-bold text-[#7A4A10]">-</span>
                        </div>
                    </div>

                    <div class="border-t border-[#D4A017]/15 pt-4 flex justify-between items-baseline">
                        <span class="text-xs font-bold text-[#7A4A10] uppercase tracking-wider">Total Pembayaran</span>
                        <span id="summary-total" class="text-2xl font-black text-[#7A4A10]">Rp 0</span>
                    </div>
                    
                    <button id="pay-button" onclick="processPayment()" class="w-full text-[#FBF6EC] bg-[#7A4A10] hover:bg-[#5f390c] py-4 rounded-2xl font-bold text-xs uppercase tracking-wider shadow-lg transition transform hover:-translate-y-0.5 text-center">
                        Lanjutkan Pembayaran
                    </button>
                </div>

                <a href="{{ route('cart.index') }}" class="block text-center text-xs text-[#7A4A10] hover:text-[#2E1A06] font-medium">
                    Kembali ke Keranjang
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    let loadedCartItems = [];
    let paymentMethod = 'DELIVERY';

    async function loadCheckoutData() {
        const token = localStorage.getItem('preloved_token');
        const method = new URLSearchParams(window.location.search).get('method') || localStorage.getItem('selected_payment_method') || 'DELIVERY';
        paymentMethod = method;
        localStorage.setItem('selected_payment_method', method);

        if (!token) {
            window.location.href = "{{ route('login') }}";
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

            loadedCartItems = await response.json();

            if (loadedCartItems.length === 0) {
                window.location.href = "{{ route('cart.index') }}";
                return;
            }

            renderCheckout();

        } catch (error) {
            console.error('Error loading checkout:', error);
            document.getElementById('loading-state').innerHTML = '<p class="text-rose-600">Gagal memuat data. Silakan coba lagi.</p>';
        }
    }

    function renderCheckout() {
        document.getElementById('loading-state').classList.add('hidden');
        document.getElementById('checkout-content').classList.remove('hidden');

        const itemsList = document.getElementById('items-list');
        itemsList.innerHTML = '';
        let subtotal = 0;

        loadedCartItems.forEach(item => {
            const product = item.product;
            if (!product) return;

            const itemPrice = parseInt(product.price);
            subtotal += itemPrice;

            const priceFormatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(itemPrice);
            const image = product.image_urls && product.image_urls.length > 0 
                ? product.image_urls[0] 
                : 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80';

            const row = document.createElement('div');
            row.className = "flex items-center gap-4 p-3 bg-[#FBF6EC] rounded-2xl border border-[#D4A017]/20";
            row.innerHTML = `
                <img src="${image}" alt="${product.title}" class="w-16 h-16 rounded-xl object-cover border border-[#D4A017]/20 bg-[#FBF6EC] flex-shrink-0">
                <div class="flex-1">
                    <h4 class="font-bold text-sm text-[#2E1A06]">${product.title}</h4>
                    <p class="text-xs text-[#7A4A10] mt-1">${priceFormatted}</p>
                </div>
            `;
            itemsList.appendChild(row);
        });

        const subtotalFormatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(subtotal);
        document.getElementById('summary-subtotal').textContent = subtotalFormatted;
        document.getElementById('summary-total').textContent = subtotalFormatted;
        document.getElementById('summary-method').textContent = paymentMethod === 'COD' ? 'COD (Bayar di Tempat)' : 'Delivery Order';
    }

    async function processPayment() {
        const token = localStorage.getItem('preloved_token');
        const payButton = document.getElementById('pay-button');
        
        payButton.disabled = true;
        payButton.textContent = 'Memproses...';

        try {
            const response = await fetch('/api/v1/payment/cart-checkout', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({
                    payment_method: paymentMethod
                })
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.error || 'Gagal membuat pembayaran');
            }

            if (data.snap_token) {
                snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        window.location.href = "{{ route('transactions.history') }}";
                    },
                    onPending: function(result) {
                        window.location.href = "{{ route('transactions.waiting') }}";
                    },
                    onError: function(result) {
                        window.location.href = "{{ route('transactions.history') }}";
                    },
                    onClose: function() {
                        payButton.disabled = false;
                        payButton.textContent = 'Lanjutkan Pembayaran';
                    }
                });
            }

        } catch (error) {
            console.error('Payment error:', error);
            alert('Gagal memproses pembayaran: ' + error.message);
            payButton.disabled = false;
            payButton.textContent = 'Lanjutkan Pembayaran';
        }
    }

    window.addEventListener('DOMContentLoaded', loadCheckoutData);
</script>
@endsection
