@extends('layouts.app')

@section('title', 'Pembayaran Gagal - PrelovedinAja')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-red-50 to-pink-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8 text-center">
            <!-- Error Icon -->
            <div class="mb-6">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-red-100">
                    <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
            </div>

            <!-- Error Message -->
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Pembayaran Gagal</h1>
            <p class="text-lg text-gray-600 mb-8">
                Maaf, pembayaran Anda tidak berhasil diproses. Silakan coba lagi dengan metode pembayaran lain.
            </p>

            <!-- Transaction Details -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8 text-left">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Detail Transaksi</h2>
                
                <div class="space-y-3 border-b pb-4 mb-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">No. Transaksi</span>
                        <span class="font-medium text-gray-900">{{ $transaction->transaction_id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">No. Order Midtrans</span>
                        <span class="font-medium text-gray-900 text-sm">{{ $transaction->order_id_midtrans }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Pembayaran</span>
                        <span class="font-bold text-indigo-600 text-lg">
                            Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status Pembayaran</span>
                        <span class="inline-block px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">
                            Gagal
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Waktu Transaksi</span>
                        <span class="font-medium text-gray-900">
                            {{ $transaction->created_at->format('d M Y, H:i') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Troubleshooting -->
            <div class="bg-red-50 rounded-lg p-6 mb-8 text-left">
                <h3 class="font-bold text-gray-900 mb-3">Kemungkinan Penyebab:</h3>
                <ul class="space-y-2 text-gray-700 list-disc list-inside">
                    <li>Saldo kartu/rekening tidak mencukupi</li>
                    <li>Kartu kredit/debit ditolak oleh bank</li>
                    <li>Timeout atau koneksi internet bermasalah</li>
                    <li>Limit transaksi harian sudah tercapai</li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('checkout') }}" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg transition">
                    Coba Pembayaran Lagi
                </a>
                <a href="{{ route('home') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-900 font-bold py-3 px-4 rounded-lg transition">
                    Kembali ke Beranda
                </a>
            </div>

            <!-- Contact Support -->
            <div class="mt-8 pt-6 border-t text-sm text-gray-600">
                <p>
                    Masalah berlanjut? 
                    <a href="#" class="text-indigo-600 hover:underline">Hubungi Dukungan Pelanggan</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
