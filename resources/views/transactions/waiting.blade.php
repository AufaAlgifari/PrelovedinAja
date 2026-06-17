@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-center">
    <div class="bg-[#F5E4B0] p-10 rounded-3xl border border-[#D4A017]/25 shadow-xl text-[#2E1A06]">
        <div class="mb-6 flex justify-center">
            <div class="p-4 bg-amber-100 rounded-full border-4 border-amber-200 animate-pulse">
                <svg class="w-16 h-16 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        
        <h1 class="text-3xl font-black mb-4">Menunggu Pembayaran</h1>
        <p class="text-[#7A4A10] font-bold mb-8">Pesanan Anda telah dicatat. Silakan selesaikan pembayaran sesuai instruksi di aplikasi Midtrans.</p>

        <div class="space-y-4">
            <a href="{{ route('transactions.history') }}" class="inline-block w-full sm:w-auto px-8 py-4 bg-[#7A4A10] hover:bg-[#5f390c] text-[#FBF6EC] font-bold text-sm uppercase tracking-wider rounded-xl shadow-lg transition">
                Cek Status Transaksi
            </a>
            <br>
            <a href="{{ route('home') }}" class="inline-block text-sm font-bold text-[#7A4A10] hover:underline">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
