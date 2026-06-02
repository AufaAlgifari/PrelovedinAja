<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preloved.in Aja - Pasar Kampus UNSOED</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 flex flex-col min-h-screen">

    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600 tracking-tight">Preloved.in</a>
                </div>
                <div class="hidden md:flex space-x-8 text-sm font-medium text-gray-600">
                    <a href="#" class="hover:text-blue-600 transition">Textbooks</a>
                    <a href="#" class="hover:text-blue-600 transition">Electronics</a>
                    <a href="#" class="hover:text-blue-600 transition">Furniture</a>
                    <a href="#" class="hover:text-blue-600 transition">Apparel</a>
                    <a href="#" class="hover:text-blue-600 transition">Dorm Life</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('cart.index') }}" class="text-gray-500 hover:text-blue-600 relative p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-blue-600 p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-blue-50 border-t border-blue-100 mt-auto py-12 text-sm text-gray-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-2 md:grid-cols-4 gap-8">
            <div>
                <span class="text-lg font-bold text-blue-600 block mb-3">Preloved.in</span>
                <p class="text-xs text-gray-400">Pasar Kampus Terpercaya UNSOED.</p>
            </div>
            <div>
                <h4 class="font-semibold text-gray-700 mb-3">Layanan</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="#" class="hover:underline">Bantuan</a></li>
                    <li><a href="#" class="hover:underline">Metode Pembayaran</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-gray-700 mb-3">Tentang Kami</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="#" class="hover:underline">Aturan Komunitas</a></li>
                    <li><a href="#" class="hover:underline">Kebijakan Privasi</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-gray-700 mb-3">Ikuti Kami</h4>
                <div class="flex space-x-3">
                    <div class="w-6 h-6 bg-gray-300 rounded-full"></div>
                    <div class="w-6 h-6 bg-gray-300 rounded-full"></div>
                    <div class="w-6 h-6 bg-gray-300 rounded-full"></div>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>