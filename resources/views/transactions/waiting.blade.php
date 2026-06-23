@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12 text-[#2E1A06]">
    <div class="border-b border-[#D4A017]/25 pb-5 mb-8">
        <h1 class="text-3xl font-extrabold tracking-tight font-heading">Menunggu Pembayaran</h1>
        <p class="text-xs text-[#7A4A10] mt-1 font-medium">Selesaikan pembayaran dalam 24 jam sebelum transaksi otomatis dibatalkan.</p>
    </div>

    <!-- Pending Transactions List Container -->
    <div id="pending-transactions-container" class="space-y-6">
        <!-- Dynamically populated via JS -->
    </div>

    <!-- Empty State -->
    <div id="empty-state" class="hidden">
        <div class="bg-[#F5E4B0] rounded-3xl border border-[#D4A017]/20 shadow-lg overflow-hidden p-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-[#FBF6EC] mb-6">
                <svg class="w-10 h-10 text-[#7A4A10]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-extrabold text-[#2E1A06] mb-2 font-heading">Tidak Ada Transaksi Menunggu</h3>
            <p class="text-sm text-[#7A4A10] mb-6">Semua transaksi Anda sudah selesai atau belum ada transaksi.</p>
            <div class="flex gap-3 justify-center">
                <a href="{{ route('home') }}" class="bg-[#7A4A10] hover:bg-[#5f390c] text-[#FBF6EC] text-sm font-bold px-6 py-3 rounded-xl shadow-md transition transform hover:-translate-y-0.5">
                    Belanja Sekarang
                </a>
                <a href="{{ route('transactions.history') }}" class="bg-[#FBF6EC] hover:bg-[#F5E4B0] text-[#7A4A10] border border-[#D4A017]/30 text-sm font-bold px-6 py-3 rounded-xl shadow-md transition transform hover:-translate-y-0.5">
                    Lihat Riwayat
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('head')
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
@endsection

@push('scripts')
<script>
    async function renderPendingTransactions() {
        const container = document.getElementById('pending-transactions-container');
        const emptyState = document.getElementById('empty-state');
        const token = localStorage.getItem('preloved_token');
        
        if (!token) {
            window.location.href = '{{ route('login') }}';
            return;
        }

        let pendingTrxs = [];

        // Fetch pending transactions from database
        try {
            const response = await fetch('/api/v1/transactions', {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });
            
            if (response.ok) {
                const allTrxs = await response.json();
                // Filter only pending transactions
                pendingTrxs = allTrxs.filter(t => {
                    if (t.status !== 'pending') return false;
                    
                    // Check if within 24 hours
                    const createdAt = new Date(t.created_at);
                    const now = new Date();
                    const hoursElapsed = (now - createdAt) / (1000 * 60 * 60);
                    
                    if (hoursElapsed >= 24) return false;
                    
                    // Calculate remaining time
                    const remainingMs = (24 * 60 * 60 * 1000) - (now - createdAt);
                    t._remainingMs = remainingMs;
                    t._hoursElapsed = hoursElapsed;
                    return true;
                });
            }
        } catch (error) {
            console.error('Error fetching transactions:', error);
            window.showToast('Gagal memuat transaksi. Silakan coba lagi.', 'error');
        }

        // Show empty state if no pending transactions
        if (pendingTrxs.length === 0) {
            container.classList.add('hidden');
            emptyState.classList.remove('hidden');
            return;
        }

        container.classList.remove('hidden');
        emptyState.classList.add('hidden');
        container.innerHTML = '';

        // Render each pending transaction
        pendingTrxs.forEach((trx, index) => {
            let displayTitle = 'Barang Preloved';
            let totalPrice = 0;
            let displayImage = 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=150&h=150&q=80';
            
            // Handle cart transactions
            if (trx.cart && trx.cart.product) {
                displayTitle = trx.cart.product.title;
                totalPrice = trx.cart.product.price;
                displayImage = trx.cart.product.image_urls ? trx.cart.product.image_urls[0] : displayImage;
            }
            // Handle single product transactions
            else if (trx.product) {
                displayTitle = trx.product.title;
                totalPrice = trx.product.price;
                displayImage = trx.product.image_urls ? trx.product.image_urls[0] : displayImage;
            }

            const priceFormatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(totalPrice || trx.amount);
            const createdAt = new Date(trx.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' });
            
            // Calculate countdown
            const remainingMs = trx._remainingMs;
            const remainingHours = Math.floor(remainingMs / (1000 * 60 * 60));
            const remainingMinutes = Math.floor((remainingMs % (1000 * 60 * 60)) / (1000 * 60));
            const progressPercent = Math.min(100, (trx._hoursElapsed / 24) * 100);
            const countdownText = remainingHours + 'j ' + remainingMinutes + 'm';
            
            // Urgency color based on remaining time
            let urgencyColor = 'bg-emerald-500';
            let urgencyText = 'text-emerald-800';
            let urgencyBorder = 'border-emerald-200';
            let urgencyBg = 'bg-emerald-50';
            if (remainingHours < 6) {
                urgencyColor = 'bg-amber-500';
                urgencyText = 'text-amber-800';
                urgencyBorder = 'border-amber-200';
                urgencyBg = 'bg-amber-50';
            }
            if (remainingHours < 2) {
                urgencyColor = 'bg-rose-500';
                urgencyText = 'text-rose-800';
                urgencyBorder = 'border-rose-200';
                urgencyBg = 'bg-rose-50';
            }
            
            const card = document.createElement('div');
            card.className = "bg-[#F5E4B0] rounded-3xl border border-[#D4A017]/20 shadow-lg overflow-hidden card-premium";
            
            card.innerHTML = `
                <!-- Card Header -->
                <div class="bg-amber-50/60 px-6 py-4 border-b border-amber-200/40 flex justify-between items-center text-xs">
                    <span class="text-[#7A4A10] font-bold uppercase tracking-wider">ID Transaksi: <strong class="text-[#2E1A06]">TRX-${trx.id}</strong></span>
                    <span class="px-3 py-1 border rounded-full text-[10px] font-extrabold uppercase tracking-wider ${urgencyBg} ${urgencyText} ${urgencyBorder}">Sisa Waktu: ${countdownText}</span>
                </div>

                <!-- Countdown Progress Bar -->
                <div class="px-6 pt-4">
                    <div class="flex justify-between text-[10px] font-bold ${urgencyText} mb-1.5">
                        <span>Sisa waktu pembayaran</span>
                        <span>${countdownText} lagi</span>
                    </div>
                    <div class="w-full h-2 bg-[#FBF6EC] rounded-full overflow-hidden">
                        <div class="h-full ${urgencyColor} rounded-full transition-all duration-500" style="width: ${progressPercent}%"></div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-6">
                    <div class="flex items-start gap-4 mb-4">
                        <img src="${displayImage}" alt="${displayTitle}" class="w-20 h-20 rounded-2xl object-cover border border-[#D4A017]/20 bg-[#FBF6EC] flex-shrink-0">
                        <div class="flex-1">
                            <h3 class="font-extrabold text-[#2E1A06] text-base leading-snug font-heading mb-2">${displayTitle}</h3>
                            <div class="space-y-1 text-xs text-[#7A4A10]">
                                <p><strong>Metode Pengiriman:</strong> ${trx.shipping_method === 'COD' ? 'COD (Bayar di Tempat)' : 'Delivery Order'}</p>
                                <p><strong>Waktu Transaksi:</strong> ${createdAt}</p>
                                <p><strong>Order ID:</strong> <span class="font-mono text-[10px]">${trx.order_id_midtrans}</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-[#FBF6EC]/50 rounded-2xl p-4 flex justify-between items-center border border-[#D4A017]/10">
                        <span class="text-sm font-bold text-[#7A4A10]">Total Pembayaran:</span>
                        <span class="text-xl font-black text-[#7A4A10] font-heading">${priceFormatted}</span>
                    </div>
                </div>

                <!-- Continue Payment Section -->
                <div class="bg-amber-50/60 p-6 border-t border-amber-200/40 space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-amber-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-xs font-bold text-amber-900 uppercase tracking-wider font-heading">Pembayaran Belum Selesai</h4>
                            <p class="text-xs text-amber-800 mt-1">Silakan selesaikan pembayaran Anda untuk melanjutkan transaksi ini.</p>
                        </div>
                    </div>
                    ${trx.snap_token ? `
                        <button onclick="continuePayment('${trx.snap_token}', '${trx.id}')" 
                                class="w-full bg-[#7A4A10] hover:bg-[#5f390c] text-[#FBF6EC] text-sm font-bold px-6 py-3 rounded-xl shadow-md transition transform hover:-translate-y-0.5">
                            Lanjutkan Pembayaran
                        </button>
                    ` : `
                        <div class="text-center text-xs text-amber-700 bg-amber-100 p-3 rounded-xl border border-amber-200">
                            Token pembayaran tidak tersedia. Silakan hubungi customer service.
                        </div>
                    `}
                </div>
            `;
            
            container.appendChild(card);
        });
    }

    function continuePayment(snapToken, transactionId) {
        if (!snapToken) {
            window.showToast('Token pembayaran tidak ditemukan.', 'error');
            return;
        }

        // Open Midtrans payment modal
        window.snap.pay(snapToken, {
            onSuccess: function(result) {
                window.showToast('Pembayaran berhasil! Transaksi Anda sedang diproses.');
                
                // Confirm payment success locally
                fetch('/payment/confirm-success', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ order_id: result.order_id || result.id || snapToken })
                })
                .then(() => {
                    setTimeout(() => {
                        window.location.href = '{{ route('transactions.history') }}';
                    }, 1000);
                })
                .catch(err => {
                    console.error('Error confirming payment:', err);
                    setTimeout(() => {
                        window.location.href = '{{ route('transactions.history') }}';
                    }, 1000);
                });
            },
            onPending: function(result) {
                window.showToast('Pembayaran tertunda. Silakan selesaikan pembayaran Anda.', 'info');
                
                // Reload the page to refresh pending transactions
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            },
            onError: function(result) {
                window.showToast('Terjadi kesalahan dalam proses pembayaran.', 'error');
            },
            onClose: function() {
                // User closed the payment modal without completing
                console.log('Payment modal closed by user');
            }
        });
    }

    window.addEventListener('DOMContentLoaded', () => {
        renderPendingTransactions();
    });
</script>
@endpush
