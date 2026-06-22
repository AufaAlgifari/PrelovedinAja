@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12 text-[#2E1A06]">
    <div class="border-b border-[#D4A017]/25 pb-5 mb-8">
        <h1 class="text-3xl font-extrabold tracking-tight font-heading">Riwayat Transaksi</h1>
        <p class="text-xs text-[#7A4A10] mt-1 font-medium">Pantau riwayat jual-beli barang preloved Anda di kampus UNSOED.</p>
    </div>

    <!-- Transactions List Container -->
    <div id="transactions-container" class="space-y-6">
        <!-- Dynamically populated via JS, with static fallback -->
    </div>
</div>
@endsection

@section('head')
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
@endsection

@push('scripts')
<script>
    async function renderTransactions() {
        const container = document.getElementById('transactions-container');
        const token = localStorage.getItem('preloved_token');
        let dbTrxs = [];

        // Fetch real database transactions
        try {
            if (token) {
                const response = await fetch('/api/v1/transactions', {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });
                if (response.ok) {
                    dbTrxs = await response.json();
                }
            }
        } catch (error) {
            console.log('Database transactions API offline, using local storage.');
        }

        // Format database transactions
        const formattedDb = dbTrxs.map(t => {
            let items = [];
            let totalPrice = 0;
            let displayTitle = 'Barang Preloved';
            let displayImage = 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=150&h=150&q=80';
            
            // Handle cart transactions (single item from cart)
            if (t.cart && t.cart.product) {
                items = [{ 
                    title: t.cart.product.title, 
                    price: t.cart.product.price, 
                    image: t.cart.product.image_urls ? t.cart.product.image_urls[0] : displayImage 
                }];
                displayTitle = t.cart.product.title;
                totalPrice = t.cart.product.price;
                displayImage = t.cart.product.image_urls ? t.cart.product.image_urls[0] : displayImage;
            }
            // Handle single product transactions (direct product relation)
            else if (t.product) {
                displayTitle = t.product.title;
                totalPrice = t.product.price;
                displayImage = t.product.image_urls ? t.product.image_urls[0] : displayImage;
                items = [{ title: displayTitle, price: totalPrice, image: displayImage }];
            }
            
            return {
                id: t.id,
                isDb: true,
                title: displayTitle,
                items: items,
                method: t.shipping_method === 'COD' ? 'COD (Bayar di Tempat)' : 'Delivery Order',
                price: totalPrice || t.amount,
                status: t.status === 'success' ? 'Berhasil' : (t.status === 'pending' ? 'Menunggu' : t.status),
                image: displayImage,
                hasReviewed: t.review !== null,
                snapToken: t.snap_token,
                orderId: t.order_id_midtrans,
                clientId: '{{ config("midtrans.client_key") }}'
            };
        });

        // Mock static completed transaction (default)
        const defaultTrx = {
            id: '992102',
            isDb: false,
            title: 'Modul Praktikum Kimia Dasar UNSOED',
            method: 'COD (Gedung Soedirman)',
            price: 35000,
            status: 'Completed',
            image: 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=150&h=150&q=80',
            hasReviewed: false
        };

        // Load transactions from localStorage
        let customTrxs = JSON.parse(localStorage.getItem('preloved_transactions') || '[]');
        
        // Combine transactions (database first, then local custom, then default mockup)
        let allTrxs = [...formattedDb, ...customTrxs];
        if (allTrxs.length === 0) {
            allTrxs.push(defaultTrx);
        }

        container.innerHTML = '';

        allTrxs.forEach((trx, index) => {
            const priceFormatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(trx.price);
            
            const card = document.createElement('div');
            card.className = "bg-[#F5E4B0] rounded-3xl border border-[#D4A017]/20 shadow-lg overflow-hidden card-premium";
            
            let statusBadgeClass = "bg-[#FBF6EC] text-[#7A4A10] border-[#D4A017]/30";
            if(trx.status === 'Berhasil' || trx.status === 'Completed') statusBadgeClass = "bg-[#7A4A10] text-[#FBF6EC] border-[#7A4A10]";
            else if(trx.status === 'Dibatalkan' || trx.status === 'Cancelled') statusBadgeClass = "bg-rose-50 text-rose-700 border-rose-100";
            else if(trx.status === 'Menunggu' || trx.status === 'Pending') statusBadgeClass = "bg-amber-50 text-amber-700 border-amber-200";

            card.innerHTML = `
                <!-- Card Header -->
                <div class="bg-[#FBF6EC]/50 px-6 py-4 border-b border-[#D4A017]/10 flex justify-between items-center text-xs">
                    <span class="text-[#7A4A10] font-bold uppercase tracking-wider">ID Transaksi: <strong class="text-[#2E1A06]">TRX-${trx.id}</strong></span>
                    <span class="px-3 py-1 border rounded-full text-[10px] font-extrabold uppercase tracking-wider ${statusBadgeClass}">${trx.status}</span>
                </div>

                <!-- Card Body -->
                <div class="p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex items-center gap-4">
                        <img src="${trx.image || 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=150&h=150&q=80'}" alt="${trx.title}" class="w-16 h-16 rounded-2xl object-cover border border-[#D4A017]/20 bg-[#FBF6EC] flex-shrink-0">
                        <div>
                            <h3 class="font-extrabold text-[#2E1A06] text-sm leading-snug font-heading">${trx.title}</h3>
                            <p class="text-xs text-[#7A4A10] mt-1 font-semibold">Metode: ${trx.method}</p>
                        </div>
                    </div>
                    <p class="text-base font-black text-[#7A4A10] font-heading">${priceFormatted}</p>
                </div>

                <!-- Continue Payment Section (for Pending transactions) -->
                ${(trx.status === 'Menunggu' || trx.status === 'Pending') && trx.snapToken ? `
                    <div class="bg-amber-50/60 p-6 border-t border-amber-200/40 space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-amber-500 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-xs font-bold text-amber-900 uppercase tracking-wider font-heading">Pembayaran Menunggu</h4>
                                <p class="text-xs text-amber-800 mt-1">Selesaikan pembayaran Anda untuk melanjutkan transaksi.</p>
                            </div>
                        </div>
                        <button onclick="continuePayment('${trx.snapToken}', '${trx.clientId}')" 
                                class="w-full bg-[#7A4A10] hover:bg-[#5f390c] text-[#FBF6EC] text-sm font-bold px-6 py-3 rounded-xl shadow-md transition transform hover:-translate-y-0.5">
                            Lanjutkan Pembayaran
                        </button>
                    </div>
                ` : ''}

                <!-- Review Section -->
                ${(trx.status === 'Completed' || trx.status === 'Berhasil') && !trx.hasReviewed ? `
                    <div id="review-box-${index}" class="bg-[#FBF6EC]/40 p-6 border-t border-[#D4A017]/10 space-y-4">
                        <div>
                            <h4 class="text-xs font-bold text-[#2E1A06] uppercase tracking-wider font-heading">Berikan Ulasan untuk Penjual</h4>
                            <p class="text-[10px] text-[#7A4A10] mt-0.5">Penilaian Anda membantu menjaga kepercayaan komunitas mahasiswa.</p>
                        </div>
                        
                        <form onsubmit="submitReview(event, ${index}, '${trx.id}', ${trx.isDb})" class="space-y-4">
                            <div class="flex flex-col sm:flex-row gap-4">
                                <div class="w-full sm:w-1/3">
                                    <label class="block text-[10px] font-bold text-[#7A4A10] uppercase tracking-wider mb-1.5">Rating Penilaian</label>
                                    <select required class="w-full px-3 py-2 bg-[#FBF6EC] border border-[#D4A017]/35 rounded-xl text-xs font-bold text-[#2E1A06] focus:outline-none focus:ring-2 focus:ring-[#7A4A10]/20">
                                        <option value="5">5 - Sangat Puas</option>
                                        <option value="4">4 - Bagus</option>
                                        <option value="3">3 - Cukup</option>
                                        <option value="2">2 - Kurang</option>
                                        <option value="1">1 - Buruk</option>
                                    </select>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-[10px] font-bold text-[#7A4A10] uppercase tracking-wider mb-1.5">Komentar Ulasan</label>
                                    <textarea required rows="1" placeholder="Tuliskan pengalaman bertransaksi dengan sesama mahasiswa di sini..." 
                                              class="w-full px-3 py-2 bg-[#FBF6EC] border border-[#D4A017]/35 rounded-xl text-xs text-[#2E1A06] placeholder-[#7A4A10]/50 focus:outline-none focus:ring-2 focus:ring-[#7A4A10]/20"></textarea>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="bg-[#7A4A10] hover:bg-[#5f390c] text-[#FBF6EC] text-xs font-bold px-5 py-2.5 rounded-xl shadow-md transition transform hover:-translate-y-0.5">
                                    Kirim Ulasan
                                </button>
                            </div>
                        </form>
                    </div>
                ` : ((trx.status === 'Completed' || trx.status === 'Berhasil') && trx.hasReviewed ? `
                    <div class="bg-[#FBF6EC]/20 p-4 border-t border-[#D4A017]/10 flex items-center justify-between text-[10px] text-[#7A4A10] font-bold uppercase tracking-wider px-6">
                        <span>Status Ulasan:</span>
                        <span class="text-emerald-700 font-extrabold">Ulasan Telah Dikirim</span>
                    </div>
                ` : ``)}
            `;
            container.appendChild(card);
        });
    }

    async function submitReview(event, index, trxId, isDb) {
        event.preventDefault();
        
        const rating = event.target.querySelector('select').value;
        const comment = event.target.querySelector('textarea').value.trim();
        const token = localStorage.getItem('preloved_token');

        if (isDb && token) {
            try {
                const response = await fetch('/api/v1/reviews', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    },
                    body: JSON.stringify({
                        transaction_id: parseInt(trxId),
                        rating: parseInt(rating),
                        comment: comment
                    })
                });

                if (response.ok) {
                    window.showToast('Ulasan berhasil disimpan di server!');
                } else {
                    const result = await response.json();
                    window.showToast(result.message || 'Gagal menyimpan ulasan.', 'error');
                    return;
                }
            } catch (error) {
                console.log('Review API offline, falling back to local simulation.');
            }
        }

        // Show local toast
        window.showToast('Terima kasih! Ulasan Anda berhasil disimpan.');
        
        // Hide review box with animation
        const reviewBox = document.getElementById(`review-box-${index}`);
        if(reviewBox) {
            reviewBox.classList.add('transition-all', 'duration-300', 'opacity-0', 'scale-95');
            setTimeout(() => {
                const indicator = document.createElement('div');
                indicator.className = "bg-[#FBF6EC]/20 p-4 border-t border-[#D4A017]/10 flex items-center justify-between text-[10px] text-[#7A4A10] font-bold uppercase tracking-wider px-6";
                indicator.innerHTML = `
                    <span>Status Ulasan:</span>
                    <span class="text-emerald-700 font-extrabold">✓ Ulasan Telah Dikirim</span>
                `;
                reviewBox.parentNode.replaceChild(indicator, reviewBox);
            }, 300);
        }
    }

    function continuePayment(snapToken, clientId) {
        if (!snapToken) {
            window.showToast('Token pembayaran tidak ditemukan.', 'error');
            return;
        }

        // Open Midtrans payment modal
        window.snap.pay(snapToken, {
            onSuccess: function(result) {
                window.showToast('Pembayaran berhasil! Transaksi Anda sedang diproses.');
                
                // Redirect to transaction success page after short delay
                setTimeout(() => {
                    window.location.href = '/transactions/history';
                }, 1500);
            },
            onPending: function(result) {
                window.showToast('Pembayaran tertunda. Silakan selesaikan pembayaran Anda.', 'info');
                
                // Redirect to pending transactions page
                setTimeout(() => {
                    window.location.href = '/transactions/waiting';
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
        renderTransactions();
    });
</script>
@endpush