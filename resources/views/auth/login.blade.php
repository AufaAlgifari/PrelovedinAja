<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk - Preloved.in Aja</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: 'rgba(var(--bg-color-rgb), <alpha-value>)',
                            100: 'rgba(var(--surface-color-rgb), <alpha-value>)',
                            500: 'rgba(var(--primary-color-rgb), <alpha-value>)',
                            600: 'rgba(var(--cta-color-rgb), <alpha-value>)',
                            900: 'rgba(var(--text-color-rgb), <alpha-value>)',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --bg-color-rgb: 251, 246, 236;
            --surface-color-rgb: 245, 228, 176;
            --primary-color-rgb: 212, 160, 23;
            --cta-color-rgb: 122, 74, 16;
            --text-color-rgb: 46, 26, 6;

            --bg-color: rgba(var(--bg-color-rgb), 1);
            --surface-color: rgba(var(--surface-color-rgb), 1);
            --primary-color: rgba(var(--primary-color-rgb), 1);
            --cta-color: rgba(var(--cta-color-rgb), 1);
            --text-color: rgba(var(--text-color-rgb), 1);
        }
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: var(--bg-color);
            color: var(--text-color);
        }
        h1, h2, h3, h4, h5, h6, .font-heading {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
        }
        input::placeholder {
            font-weight: normal !important;
            text-transform: none !important;
            font-size: 0.75rem !important;
            opacity: 0.6;
        }
        input:not([type="checkbox"]), select {
            border-radius: 5px !important;
        }
    </style>
</head>
<body class="h-screen w-screen overflow-hidden flex items-center justify-center p-4">
    
    <div class="max-w-md w-full bg-[#F5E4B0] p-8 sm:p-10 rounded-3xl border border-[#D4A017]/25 shadow-xl relative overflow-hidden flex flex-col justify-between">
        
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-[#D4A017]/10 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-[#7A4A10]/10 rounded-full blur-2xl"></div>

        <!-- Back Link to Home -->
        <div class="absolute top-4 left-4 z-10">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-1 text-[10px] font-bold text-[#7A4A10] hover:text-[#2E1A06] transition bg-white/50 px-2.5 py-1 rounded-full border border-[#D4A017]/20">
                Kembali
            </a>
        </div>

        <div class="text-center relative pt-4">
            <div class="inline-flex items-center justify-center p-3 bg-[#FBF6EC] rounded-2xl mb-4 border-2 border-[#7A4A10] shadow-md">
                <a href="{{ route('home') }}" class="hover:opacity-90 transition block">
                    <svg class="w-8 h-8" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 20L165 42L100 64L35 42L100 20Z" fill="var(--primary-color)" />
                        <path d="M52 48.5V68C52 70.5 49.5 72 47 72C44.5 72 42 70.5 42 68V45" stroke="var(--cta-color)" stroke-width="4.5" stroke-linecap="round"/>
                        <circle cx="47" cy="72" r="6.5" fill="var(--text-color)"/>
                        <path d="M68 62C68 38 132 38 132 62" stroke="var(--surface-color)" stroke-width="15" stroke-linecap="round"/>
                        <path d="M42 62H158L168 165C168 171 163 175 157 175H43C37 175 32 171 32 165L42 62Z" fill="var(--primary-color)"/>
                        <path d="M72 88H108C122 88 132 98 132 110C132 122 122 132 108 132H72V88ZM72 132V150" stroke="var(--bg-color)" stroke-width="13" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
            <h2 class="text-3xl font-extrabold text-[#2E1A06] tracking-tight font-heading">Selamat Datang</h2>
            <p class="text-xs text-[#2E1A06] font-bold uppercase tracking-wider mt-2 flex items-center justify-center gap-1.5 bg-[#FBF6EC] px-4 py-2 rounded-full w-max mx-auto border border-[#D4A017]/20">
                <span>🔐</span> Khusus Mahasiswa UNSOED
            </p>
        </div>

        <form id="login-form" class="mt-6 space-y-4" onsubmit="handleLogin(event)">
            @csrf
            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-bold text-[#7A4A10] uppercase tracking-wider mb-1">Email Institusi UNSOED</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-[#7A4A10]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path></svg>
                        </span>
                        <input type="email" name="email" id="email" required 
                               pattern=".*\.ac\.id$" 
                               title="Harus menggunakan email institusi berakhiran .ac.id"
                               placeholder="nama@mhs.unsoed.ac.id" 
                               class="w-full pl-10 pr-4 py-2.5 bg-[#FBF6EC] border border-[#D4A017]/30 rounded-[5px] text-sm focus:border-[#7A4A10] focus:ring-4 focus:ring-[#7A4A10]/10 focus:outline-none transition-all text-[#2E1A06]">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#7A4A10] uppercase tracking-wider mb-1">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-[#7A4A10] pointer-events-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </span>
                        <input type="password" name="password" id="password" required placeholder="••••••••" 
                               class="w-full pl-10 pr-10 py-2.5 bg-[#FBF6EC] border border-[#D4A017]/30 rounded-[5px] text-sm focus:border-[#7A4A10] focus:ring-4 focus:ring-[#7A4A10]/10 focus:outline-none transition-all text-[#2E1A06]">
                        <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#7A4A10] hover:text-[#2E1A06] transition focus:outline-none">
                            <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between text-xs pt-1">
                <div class="flex items-center">
                    <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-[#7A4A10] focus:ring-[#7A4A10] border-[#D4A017]/30 rounded bg-[#FBF6EC] cursor-pointer">
                    <label for="remember-me" class="ml-2 block text-[#2E1A06] font-semibold cursor-pointer">Ingat saya</label>
                </div>
                <a href="{{ route('password.request') }}" class="font-bold text-[#7A4A10] hover:text-[#2E1A06] hover:underline">Lupa Password?</a>
            </div>

            <div class="pt-2">
                <button type="submit" id="btn-submit" class="w-full py-3.5 px-4 text-sm font-bold text-[#FBF6EC] bg-[#7A4A10] hover:bg-[#5f390c] rounded-2xl shadow-lg transition-all focus:outline-none flex items-center justify-center gap-2">
                    <span id="btn-text">Masuk Sekarang</span>
                    <span id="btn-loader" class="hidden animate-spin h-5 w-5 border-2 border-[#FBF6EC] border-t-transparent rounded-full"></span>
                </button>
            </div>
        </form>
        
        <div class="mt-5 text-center text-xs text-[#2E1A06]/70">
            Belum punya akun? <a href="{{ route('register') }}" onclick="showRegisterMock()" class="text-[#7A4A10] font-extrabold hover:text-[#2E1A06] hover:underline">Daftar Akun Baru</a>
        </div>
    </div>

    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2 pointer-events-none"></div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
            }
        }



        // Local toast notifications
        window.showToast = function(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = `flex items-center gap-3 px-5 py-3.5 rounded-xl shadow-lg border text-sm font-semibold transition-all duration-300 transform translate-y-10 opacity-0 pointer-events-auto max-w-sm`;
            
            if (type === 'success') {
                toast.className += ' bg-emerald-50 text-emerald-800 border-emerald-100';
                toast.innerHTML = `<span class="text-emerald-500">✓</span><span>${message}</span>`;
            } else if (type === 'error') {
                toast.className += ' bg-rose-50 text-rose-800 border-rose-100';
                toast.innerHTML = `<span class="text-rose-500">✕</span><span>${message}</span>`;
            } else {
                toast.className += ' bg-amber-50 text-amber-800 border-amber-100';
                toast.innerHTML = `<span class="text-amber-500">ℹ</span><span>${message}</span>`;
            }

            container.appendChild(toast);
            setTimeout(() => toast.classList.remove('translate-y-10', 'opacity-0'), 10);
            setTimeout(() => {
                toast.classList.add('translate-y-10', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        };

        function showRegisterMock() {
            window.showToast('Gunakan formulir login langsung dengan email @mhs.unsoed.ac.id untuk simulasi cepat!', 'info');
        }

        async function handleLogin(e) {
            e.preventDefault();
            
            const rememberMe = document.getElementById('remember-me').checked;
            if (!rememberMe) {
                window.showToast('Centang ingat saya', 'error');
                return;
            }
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const btnSubmit = document.getElementById('btn-submit');
            const btnText = document.getElementById('btn-text');
            const btnLoader = document.getElementById('btn-loader');

            // Loading state
            btnSubmit.disabled = true;
            btnText.textContent = 'Memverifikasi...';
            btnLoader.classList.remove('hidden');

            // Get redirect target from query parameter
            const urlParams = new URLSearchParams(window.location.search);
            const redirectUrl = urlParams.get('redirect') ? decodeURIComponent(urlParams.get('redirect')) : "{{ route('home') }}";

            try {
                const response = await fetch('/api/v1/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({ email, password, remember: rememberMe })
                });

                const result = await response.json();

                if (response.ok && result.token) {
                    localStorage.setItem('preloved_token', result.token);
                    localStorage.setItem('preloved_user', JSON.stringify(result.user));
                    window.showToast('Login Berhasil! Selamat berbelanja.');
                    setTimeout(() => {
                        window.location.href = redirectUrl;
                    }, 1000);
                    return;
                } else {
                    window.showToast(result.message || 'Email atau password salah.', 'error');
                    
                    btnSubmit.disabled = false;
                    btnText.textContent = 'Masuk Sekarang';
                    btnLoader.classList.add('hidden');
                    return;
                }
            } catch (error) {
                console.log('Database auth offline atau terjadi error jaringan, menggunakan mode demo:', error);

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
                    
                    btnSubmit.disabled = false;
                    btnText.textContent = 'Masuk Sekarang';
                    btnLoader.classList.add('hidden');
                    
                    window.showToast('Login Berhasil (Mode Demo Kampus)!');
                    setTimeout(() => {
                        window.location.href = redirectUrl;
                    }, 1000);
                }, 800);
            }
        }
    </script>
</body>
</html>