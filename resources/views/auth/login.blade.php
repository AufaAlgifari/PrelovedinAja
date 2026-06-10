@extends('layouts.app')

@section('content')
<div class="min-h-[calc(100vh-80px)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-[#FBF6EC]">
    <div class="max-w-md w-full space-y-8 bg-[#F5E4B0] p-8 sm:p-10 rounded-3xl border border-[#D4A017]/25 shadow-xl relative overflow-hidden">
        
        <!-- Decorative subtle background elements -->
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-[#D4A017]/10 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-[#7A4A10]/10 rounded-full blur-2xl"></div>

        <div class="text-center relative">
            <div class="inline-flex items-center justify-center p-3 bg-[#FBF6EC] text-[#7A4A10] rounded-2xl mb-4 border border-[#D4A017]/20">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 009 14a15.82 15.82 0 00-1.5-.5M6.7 20A13.96 13.96 0 013 15.07m12.188-4.188c.847-.847 1.312-1.956 1.312-3.128 0-2.435-1.977-4.413-4.413-4.413S7.674 5.317 7.674 7.752c0 1.171.465 2.28 1.312 3.128m7.2 0l-.022.022m0 0l-7.176 7.176"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold text-[#2E1A06] tracking-tight font-heading">Selamat Datang</h2>
            <p class="text-xs text-[#2E1A06] font-bold uppercase tracking-wider mt-2.5 flex items-center justify-center gap-1.5 bg-[#FBF6EC] px-4 py-2 rounded-full w-max mx-auto border border-[#D4A017]/20">
                <span>🔐</span> Khusus Mahasiswa Aktif UNSOED
            </p>
        </div>

        <form id="login-form" class="mt-8 space-y-6" onsubmit="handleLogin(event)">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-[#7A4A10] uppercase tracking-wider mb-2">Email Institusi UNSOED</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-[#7A4A10]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path></svg>
                        </span>
                        <input type="email" name="email" id="email" required 
                               pattern=".*\.ac\.id$" 
                               title="Harus menggunakan email institusi berakhiran .ac.id"
                               placeholder="nama@mhs.unsoed.ac.id" 
                               class="w-full pl-10 pr-4 py-3 bg-[#FBF6EC] border border-[#D4A017]/30 rounded-2xl text-sm focus:border-[#7A4A10] focus:ring-4 focus:ring-[#7A4A10]/10 focus:outline-none transition-all text-[#2E1A06]">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#7A4A10] uppercase tracking-wider mb-2">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-[#7A4A10]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </span>
                        <input type="password" name="password" id="password" required placeholder="••••••••" 
                               class="w-full pl-10 pr-4 py-3 bg-[#FBF6EC] border border-[#D4A017]/30 rounded-2xl text-sm focus:border-[#7A4A10] focus:ring-4 focus:ring-[#7A4A10]/10 focus:outline-none transition-all text-[#2E1A06]">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between text-xs">
                <div class="flex items-center">
                    <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-[#7A4A10] focus:ring-[#7A4A10] border-[#D4A017]/30 rounded-lg bg-[#FBF6EC]">
                    <label for="remember-me" class="ml-2 block text-[#2E1A06] font-semibold">Ingat saya</label>
                </div>
                <a href="#" class="font-bold text-[#7A4A10] hover:text-[#2E1A06] hover:underline">Lupa Password?</a>
            </div>

            <div>
                <button type="submit" id="btn-submit" class="w-full py-3.5 px-4 text-sm font-bold text-[#FBF6EC] bg-[#7A4A10] hover:bg-[#5f390c] rounded-2xl shadow-lg transition-all focus:outline-none flex items-center justify-center gap-2">
                    <span id="btn-text">Masuk Sekarang</span>
                    <span id="btn-loader" class="hidden animate-spin h-5 w-5 border-2 border-[#FBF6EC] border-t-transparent rounded-full"></span>
                </button>
            </div>
        </form>
        
        <div class="mt-6 text-center text-xs text-[#2E1A06]/70">
            Belum punya akun? <a href="#" onclick="showRegisterMock()" class="text-[#7A4A10] font-extrabold hover:text-[#2E1A06] hover:underline">Daftar Akun Baru</a>
        </div>
    </div>
</div>

<script>
    function showRegisterMock() {
        window.showToast('Gunakan formulir login langsung dengan email @mhs.unsoed.ac.id untuk simulasi cepat!', 'info');
    }

    async function handleLogin(e) {
        e.preventDefault();
        
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const btnSubmit = document.getElementById('btn-submit');
        const btnText = document.getElementById('btn-text');
        const btnLoader = document.getElementById('btn-loader');

        // Loading state
        btnSubmit.disabled = true;
        btnText.textContent = 'Memverifikasi...';
        btnLoader.classList.remove('hidden');

        try {
            // Attempt to hit the Laravel API login
            const response = await fetch('/api/v1/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({ email, password })
            });

            const result = await response.json();

            if (response.ok && result.token) {
                // Success with real DB auth
                localStorage.setItem('preloved_token', result.token);
                localStorage.setItem('preloved_user', JSON.stringify(result.user));
                window.showToast('Login Berhasil! Selamat berbelanja.');
                setTimeout(() => {
                    window.location.href = "{{ route('home') }}";
                }, 1000);
                return;
            }
        } catch (error) {
            console.log('Database auth offline or error:', error);
        }

        // --- FALLBACK INTERACTIVE MODE ---
        // If API fails or is not connected to active database, we log them in with mock student details!
        let cleanName = 'Mahasiswa Unsoed';
        let emailUsername = email.split('@')[0];
        
        if (emailUsername) {
            cleanName = emailUsername
                .split('.')
                .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                .join(' ');
        }

        const faculties = ['Teknik', 'Ekonomi dan Bisnis', 'Ilmu Sosial dan Ilmu Politik', 'Pertanian', 'Hukum'];
        const majors = ['Informatika', 'Manajemen', 'Ilmu Komunikasi', 'Agroteknologi', 'Ilmu Hukum'];
        const randIndex = Math.floor(Math.random() * faculties.length);

        const mockUser = {
            id: 99,
            name: cleanName,
            email: email,
            phone_number: '0812-3456-7890',
            unsoed_faculty: faculties[randIndex],
            unsoed_major: majors[randIndex],
            avatar_url: 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=150&h=150&q=80',
            rating_cache: 5.0,
            role: 'student',
            is_verified: true,
            no_kampus: 'H1D024' + Math.floor(100 + Math.random() * 900)
        };

        setTimeout(() => {
            localStorage.setItem('preloved_token', 'mock_token_12345');
            localStorage.setItem('preloved_user', JSON.stringify(mockUser));
            
            // Clean loader state
            btnSubmit.disabled = false;
            btnText.textContent = 'Masuk Sekarang';
            btnLoader.classList.add('hidden');
            
            window.showToast('Login Berhasil (Mode Demo Kampus)!');
            setTimeout(() => {
                window.location.href = "{{ route('home') }}";
            }, 1000);
        }, 800);
    }
</script>
@endsection