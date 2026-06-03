@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="border-b border-slate-100 pb-5 mb-8">
        <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Riwayat Transaksi</h1>
        <p class="text-xs text-slate-400 mt-1">Pantau riwayat jual-beli barang preloved Anda di kampus UNSOED.</p>
    </div>

    <!-- Transactions List Container -->
    <div id="transactions-container" class="space-y-6">
        <!-- Dynamically populated via JS, with static fallback -->
    </div>
</div>

<script>
    function renderTransactions() {
        const container = document.getElementById('transactions-container');
        
        // Mock static completed transaction (default)
        const defaultTrx = {
            id: 'TRX-992102A',
            title: 'Modul Praktikum Kimia Dasar UNSOED',
            method: 'COD (Gedung Soedirman)',
            price: 35000,
            status: 'Completed',
            image: 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=150&h=150&q=80',
            hasReviewed: false
        };

        // You can load transactions from localStorage if the user just checked out!
        let customTrxs = JSON.parse(localStorage.getItem('preloved_transactions') || '[]');
        
        // Combine transactions (custom checked-out ones first)
        let allTrxs = [...customTrxs, defaultTrx];

        container.innerHTML = '';

        allTrxs.forEach((trx, index) => {
            const priceFormatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(trx.price);
            
            const card = document.createElement('div');
            card.className = "bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-100/30 overflow-hidden card-premium";
            
            let statusBadgeClass = "bg-brand-50 text-brand-700 border-brand-100";
            if(trx.status === 'Completed') statusBadgeClass = "bg-emerald-50 text-emerald-700 border-emerald-100";
            else if(trx.status === 'Cancelled') statusBadgeClass = "bg-rose-50 text-rose-700 border-rose-100";

            card.innerHTML = `
                <!-- Card Header -->
                <div class="bg-slate-50/50 px-6 py-4 border-b border-slate-100 flex justify-between items-center text-xs">
                    <span class="text-slate-400 font-bold uppercase tracking-wider">ID Transaksi: <strong class="text-slate-700">${trx.id}</strong></span>
                    <span class="px-3 py-1 border rounded-full text-[10px] font-extrabold uppercase tracking-wider ${statusBadgeClass}">${trx.status}</span>
                </div>

                <!-- Card Body -->
                <div class="p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex items-center gap-4">
                        <img src="${trx.image || 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=150&h=150&q=80'}" alt="${trx.title}" class="w-16 h-16 rounded-2xl object-cover border border-slate-100 bg-slate-50">
                        <div>
                            <h3 class="font-bold text-slate-800 text-sm leading-snug">${trx.title}</h3>
                            <p class="text-xs text-slate-400 mt-1 font-semibold">📍 Metode: ${trx.method}</p>
                        </div>
                    </div>
                    <p class="text-base font-black text-brand-600">${priceFormatted}</p>
                </div>

                <!-- Review Section (Only for completed or custom transactions) -->
                ${trx.status === 'Completed' && !trx.hasReviewed ? `
                    <div id="review-box-${index}" class="bg-brand-50/10 p-6 border-t border-brand-100/50 space-y-4">
                        <div>
                            <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Berikan Ulasan untuk Penjual</h4>
                            <p class="text-[10px] text-slate-400 mt-0.5">Penilaian Anda membantu menjaga kepercayaan komunitas mahasiswa.</p>
                        </div>
                        
                        <form onsubmit="submitReview(event, ${index})" class="space-y-4">
                            <div class="flex flex-col sm:flex-row gap-4">
                                <div class="w-full sm:w-1/3">
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Rating Penilaian</label>
                                    <select required class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-400">
                                        <option value="5">⭐⭐⭐⭐⭐ (5 - Sangat Puas)</option>
                                        <option value="4">⭐⭐⭐⭐ (4 - Bagus)</option>
                                        <option value="3">⭐⭐⭐ (3 - Cukup)</option>
                                        <option value="2">⭐⭐ (2 - Kurang)</option>
                                        <option value="1">⭐ (1 - Buruk)</option>
                                    </select>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Komentar Ulasan</label>
                                    <textarea required rows="1" placeholder="Tuliskan pengalaman bertransaksi dengan sesama mahasiswa di sini..." 
                                              class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-400"></textarea>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="bg-brand-500 hover:bg-brand-600 text-slate-900 text-xs font-bold px-5 py-2.5 rounded-xl shadow-md transition transform hover:-translate-y-0.5">
                                    Kirim Ulasan Mahasiswa
                                </button>
                            </div>
                        </form>
                    </div>
                ` : `
                    <div class="bg-slate-50/50 p-4 border-t border-slate-100 flex items-center justify-between text-[10px] text-slate-400 font-bold uppercase tracking-wider px-6">
                        <span>Status Ulasan:</span>
                        <span class="text-emerald-600">✓ Ulasan Telah Dikirim</span>
                    </div>
                `}
            `;
            container.appendChild(card);
        });
    }

    function submitReview(event, index) {
        event.preventDefault();
        
        // Show success toast
        window.showToast('Terima kasih! Ulasan Anda berhasil dikirim.');
        
        // Hide review box with animation
        const reviewBox = document.getElementById(`review-box-${index}`);
        if(reviewBox) {
            reviewBox.classList.add('transition-all', 'duration-300', 'opacity-0', 'scale-95');
            setTimeout(() => {
                // Replace with static reviewed indicator
                const indicator = document.createElement('div');
                indicator.className = "bg-slate-50/50 p-4 border-t border-slate-100 flex items-center justify-between text-[10px] text-slate-400 font-bold uppercase tracking-wider px-6";
                indicator.innerHTML = `
                    <span>Status Ulasan:</span>
                    <span class="text-emerald-600">✓ Ulasan Telah Dikirim</span>
                `;
                reviewBox.parentNode.replaceChild(indicator, reviewBox);
            }, 300);
        }
    }

    window.addEventListener('DOMContentLoaded', () => {
        renderTransactions();
    });
</script>
@endsection