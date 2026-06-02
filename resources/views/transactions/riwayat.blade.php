@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <h1 class="text-2xl font-bold text-gray-800 mb-8">Riwayat Transaksi Kampus</h1>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-6">
        <div class="bg-gray-50 px-6 py-4 border-b flex justify-between items-center text-xs">
            <span class="text-gray-500">ID Transaksi: <strong>TRX-992102A</strong></span>
            <span class="px-2.5 py-1 bg-blue-50 text-blue-700 font-bold rounded-full">Completed</span>
        </div>

        <div class="p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-20 h-20 bg-gray-100 rounded-xl"></div>
                <div>
                    <h3 class="font-semibold text-gray-800 text-sm">Modul Praktikum Kimia Dasar UNSOED</h3>
                    <p class="text-xs text-gray-400 mt-1">Metode: COD (Gedung Soedirman)</p>
                </div>
            </div>
            <p class="text-md font-bold text-blue-600">Rp 35.000</p>
        </div>

        <div class="bg-blue-50/50 p-6 border-t border-blue-50">
            <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-3">Berikan Ulasan untuk Penjual</h4>
            
            <form action="/api/reviews" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="transaction_id" value="1">
                
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Rating Penilaian (1-5)</label>
                    <select name="rating" required class="px-3 py-1.5 bg-white border rounded-lg text-xs font-semibold text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="5">⭐⭐⭐⭐⭐ (5 - Sangat Puas)</option>
                        <option value="4">⭐⭐⭐⭐ (4 - Bagus)</option>
                        <option value="3">⭐⭐⭐ (3 - Cukup)</option>
                        <option value="2">⭐⭐ (2 - Kurang)</option>
                        <option value="1">⭐ (1 - Buruk)</option>
                    </select>
                </div>

                <div>
                    <textarea name="comment" rows="2" placeholder="Tuliskan pengalaman bertransaksi dengan sesama mahasiswa di sini..." 
                              class="w-full p-3 bg-white border rounded-xl text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                </div>

                <button type="submit" class="bg-blue-600 text-white text-xs font-semibold px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Kirim Ulasan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection