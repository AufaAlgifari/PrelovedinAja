@extends('layouts.app')

@section('title', 'Checkout - PrelovedinAja')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Checkout</h1>
            <p class="mt-2 text-gray-600">Tinjau pesanan Anda dan lanjutkan ke pembayaran</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Summary -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Ringkasan Pesanan</h2>
                    
                    <div class="space-y-6">
                        @forelse($cartItems as $cartItem)
                            <div class="flex border-b pb-6 last:border-b-0">
                                <!-- Product Image -->
                                <div class="flex-shrink-0">
                                    @if($cartItem->product->image_urls)
                                        @php
                                            $images = is_array($cartItem->product->image_urls) 
                                                ? $cartItem->product->image_urls 
                                                : json_decode($cartItem->product->image_urls, true);
                                        @endphp
                                        <img src="{{ $images[0] ?? 'https://via.placeholder.com/100' }}" 
                                             alt="{{ $cartItem->product->title }}"
                                             class="w-20 h-20 object-cover rounded">
                                    @else
                                        <img src="https://via.placeholder.com/100" 
                                             alt="No image"
                                             class="w-20 h-20 object-cover rounded bg-gray-200">
                                    @endif
                                </div>

                                <!-- Product Details -->
                                <div class="ml-4 flex-1">
                                    <h3 class="text-lg font-medium text-gray-900">
                                        {{ $cartItem->product->title }}
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-600">
                                        Kondisi: {{ $cartItem->product->condition }}
                                    </p>
                                    <p class="mt-1 text-sm text-gray-600">
                                        Penjual: {{ $cartItem->product->seller->name ?? 'Unknown' }}
                                    </p>
                                </div>

                                <!-- Price -->
                                <div class="text-right">
                                    <p class="text-lg font-bold text-indigo-600">
                                        Rp {{ number_format($cartItem->product->price, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <p class="text-gray-600">Keranjang Anda kosong</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Alamat Pengiriman</h2>
                    @if(Auth::check())
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <p class="mt-1 text-gray-900">{{ Auth::user()->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <p class="mt-1 text-gray-900">{{ Auth::user()->email }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                                <p class="mt-1 text-gray-900">{{ Auth::user()->phone ?? 'N/A' }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-gray-600">Silakan login untuk melihat alamat pengiriman</p>
                    @endif
                </div>
            </div>

            <!-- Payment Summary & Button -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Total Pembayaran</h2>
                    
                    <div class="space-y-4 border-b pb-4 mb-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium text-gray-900">
                                Rp {{ number_format($totalAmount, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Biaya Pengiriman</span>
                            <span class="font-medium text-gray-900">Gratis</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mb-6">
                        <span class="text-lg font-bold text-gray-900">Total</span>
                        <span class="text-2xl font-bold text-indigo-600">
                            Rp {{ number_format($totalAmount, 0, ',', '.') }}
                        </span>
                    </div>

                    <!-- Payment Methods Info -->
                    <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                        <p class="text-sm font-medium text-blue-900 mb-2">Metode Pembayaran Tersedia:</p>
                        <ul class="text-sm text-blue-800 space-y-1">
                            <li>✓ Kartu Kredit/Debit</li>
                            <li>✓ Transfer Bank</li>
                            <li>✓ E-Wallet (GoPay, OVO, Dana, LinkAja)</li>
                            <li>✓ QRIS</li>
                            <li>✓ Cicilan 0%</li>
                        </ul>
                    </div>

                    <!-- Pay Button -->
                    <button 
                        id="pay-button"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200"
                    >
                        Lanjut ke Pembayaran
                    </button>

                    <button 
                        onclick="window.history.back()"
                        class="w-full mt-3 bg-gray-200 hover:bg-gray-300 text-gray-900 font-bold py-3 px-4 rounded-lg transition duration-200"
                    >
                        Kembali
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Midtrans Snap SDK -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
document.getElementById('pay-button').addEventListener('click', function() {
    // Show loading
    const btn = this;
    btn.disabled = true;
    btn.textContent = 'Memproses...';

    // Create snap token
    fetch('{{ route("payment.create-snap-token") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.snap_token) {
            // Open Midtrans Snap modal
            snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    console.log('Payment success:', result);
                    window.location.href = '{{ route("payment.success") }}?order_id=' + result.order_id;
                },
                onPending: function(result) {
                    console.log('Payment pending:', result);
                    window.location.href = '{{ route("payment.pending") }}?order_id=' + result.order_id;
                },
                onError: function(result) {
                    console.log('Payment error:', result);
                    window.location.href = '{{ route("payment.error") }}?order_id=' + result.order_id;
                },
                onClose: function() {
                    console.log('Customer closed the popup without finishing the payment');
                    btn.disabled = false;
                    btn.textContent = 'Lanjut ke Pembayaran';
                }
            });
        } else {
            alert('Error: ' + (data.error || 'Gagal membuat snap token'));
            btn.disabled = false;
            btn.textContent = 'Lanjut ke Pembayaran';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan: ' + error.message);
        btn.disabled = false;
        btn.textContent = 'Lanjut ke Pembayaran';
    });
});
</script>
@endsection
