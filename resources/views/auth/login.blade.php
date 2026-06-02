@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto my-16 bg-white p-8 rounded-2xl border border-gray-100 shadow-md">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">Masuk ke Preloved.in</h2>
    <p class="text-xs text-center text-red-500 font-semibold mb-6">Khusus Mahasiswa Aktif UNSOED (.ac.id)</p>

    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-3 mb-4 rounded text-xs text-red-700">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="/api/login" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Email Institusi</label>
            <input type="email" name="email" required 
                   pattern=".*\.ac\.id$" 
                   title="Harus menggunakan email institusi berakhiran .ac.id"
                   placeholder="contoh@mhs.unsoed.ac.id" 
                   class="w-full px-4 py-2.5 border rounded-lg text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Password</label>
            <input type="password" name="password" required placeholder="••••••••" 
                   class="w-full px-4 py-2.5 border rounded-lg text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-lg text-sm font-semibold hover:bg-blue-700 transition shadow-sm">
            Masuk
        </button>
    </form>
    
    <div class="mt-6 text-center text-xs text-gray-500">
        Belum punya akun? <a href="#" class="text-blue-600 font-medium hover:underline">Daftar Sekarang</a>
    </div>
</div>
@endsection