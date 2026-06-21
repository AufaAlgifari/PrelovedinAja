<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - Preloved.in Aja</title>
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
<body class="w-screen overflow-y-auto md:overflow-hidden md:h-screen flex items-center justify-center p-4">
    
    <div class="max-w-xl w-full bg-[#F5E4B0] p-6 sm:p-8 rounded-3xl border border-[#D4A017]/25 shadow-xl relative overflow-hidden flex flex-col justify-between my-auto">
        
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-[#D4A017]/10 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-[#7A4A10]/10 rounded-full blur-2xl"></div>

        <!-- Back Link to Home -->
        <div class="absolute top-4 left-4 z-10">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-1 text-[10px] font-bold text-[#7A4A10] hover:text-[#2E1A06] transition bg-white/50 px-2.5 py-1 rounded-full border border-[#D4A017]/20">
                Kembali
            </a>
        </div>

        <div class="text-center relative pt-4">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-[#2E1A06] tracking-tight font-heading">Daftar Akun Baru</h2>
            <p class="text-[10px] text-[#2E1A06] font-bold uppercase tracking-wider mt-2.5 flex items-center justify-center gap-1.5 bg-[#FBF6EC] px-4 py-2 rounded-full w-max mx-auto border border-[#D4A017]/20">
                <span>🎓</span> Registrasi Mahasiswa UNSOED
            </p>
        </div>

        <form id="register-form" class="mt-6 space-y-4" onsubmit="handleRegister(event)">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-bold text-[#7A4A10] uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                    <input type="text" id="name" required placeholder="Misal: Aufa Algifari" 
                           class="w-full px-4 py-2 bg-[#FBF6EC] border border-[#D4A017]/30 rounded-[5px] text-xs sm:text-sm focus:border-[#7A4A10] focus:ring-4 focus:ring-[#7A4A10]/10 focus:outline-none transition-all text-[#2E1A06]">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-[#7A4A10] uppercase tracking-wider mb-1.5">NIM / Nomor Kampus</label>
                    <input type="text" id="no_kampus" required placeholder="Misal: H1D024001" 
                           class="w-full px-4 py-2 bg-[#FBF6EC] border border-[#D4A017]/30 rounded-[5px] text-xs sm:text-sm focus:border-[#7A4A10] focus:ring-4 focus:ring-[#7A4A10]/10 focus:outline-none transition-all text-[#2E1A06] font-bold uppercase">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-[#7A4A10] uppercase tracking-wider mb-1.5">Email Institusi UNSOED</label>
                    <input type="email" id="email" required pattern=".*\.ac\.id$" title="Harus menggunakan email institusi berakhiran .ac.id" placeholder="nama@mhs.unsoed.ac.id" 
                           class="w-full px-4 py-2 bg-[#FBF6EC] border border-[#D4A017]/30 rounded-[5px] text-xs sm:text-sm focus:border-[#7A4A10] focus:ring-4 focus:ring-[#7A4A10]/10 focus:outline-none transition-all text-[#2E1A06]">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-[#7A4A10] uppercase tracking-wider mb-1.5">Nomor WhatsApp</label>
                    <input type="text" id="phone_number" required placeholder="Misal: 08123456789" 
                           class="w-full px-4 py-2 bg-[#FBF6EC] border border-[#D4A017]/30 rounded-[5px] text-xs sm:text-sm focus:border-[#7A4A10] focus:ring-4 focus:ring-[#7A4A10]/10 focus:outline-none transition-all text-[#2E1A06]">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-[#7A4A10] uppercase tracking-wider mb-1.5">Fakultas</label>
                    <select id="unsoed_faculty" required class="w-full px-4 py-2 bg-[#FBF6EC] border border-[#D4A017]/30 rounded-[5px] text-xs sm:text-sm focus:border-[#7A4A10] focus:ring-4 focus:ring-[#7A4A10]/10 focus:outline-none transition-all text-[#2E1A06]">
                        <option value="" disabled selected>Pilih Fakultas</option>
                        <option value="Teknik">Fakultas Teknik</option>
                        <option value="Ekonomi dan Bisnis">Fakultas Ekonomi & Bisnis</option>
                        <option value="Ilmu Sosial dan Ilmu Politik">Fakultas ISIP</option>
                        <option value="Hukum">Fakultas Hukum</option>
                        <option value="Kedokteran">Fakultas Kedokteran</option>
                        <option value="Pertanian">Fakultas Pertanian</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-[#7A4A10] uppercase tracking-wider mb-1.5">Jurusan / Program Studi</label>
                    <input type="text" id="unsoed_major" required placeholder="Misal: Teknik Informatika" 
                           class="w-full px-4 py-2 bg-[#FBF6EC] border border-[#D4A017]/30 rounded-[5px] text-xs sm:text-sm focus:border-[#7A4A10] focus:ring-4 focus:ring-[#7A4A10]/10 focus:outline-none transition-all text-[#2E1A06]">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-[#7A4A10] uppercase tracking-wider mb-1.5">Password</label>
                    <input type="password" id="password" required placeholder="••••••••" 
                           class="w-full px-4 py-2 bg-[#FBF6EC] border border-[#D4A017]/30 rounded-[5px] text-xs sm:text-sm focus:border-[#7A4A10] focus:ring-4 focus:ring-[#7A4A10]/10 focus:outline-none transition-all text-[#2E1A06]">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-[#7A4A10] uppercase tracking-wider mb-1.5">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" required placeholder="••••••••" 
                           class="w-full px-4 py-2 bg-[#FBF6EC] border border-[#D4A017]/30 rounded-[5px] text-xs sm:text-sm focus:border-[#7A4A10] focus:ring-4 focus:ring-[#7A4A10]/10 focus:outline-none transition-all text-[#2E1A06]">
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" id="btn-submit" class="w-full py-3 px-4 text-xs font-bold text-[#FBF6EC] bg-[#7A4A10] hover:bg-[#5f390c] rounded-2xl shadow-lg transition-all focus:outline-none flex items-center justify-center gap-2">
                    <span id="btn-text">Daftar Akun Mahasiswa</span>
                    <span id="btn-loader" class="hidden animate-spin h-5 w-5 border-2 border-[#FBF6EC] border-t-transparent rounded-full"></span>
                </button>
            </div>
        </form>
        
        <div class="mt-5 text-center text-xs text-[#2E1A06]/70">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-[#7A4A10] font-extrabold hover:text-[#2E1A06] hover:underline">Masuk Di Sini</a>
        </div>
    </div>

    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2 pointer-events-none"></div>

    <script>
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

        async function handleRegister(e) {
            e.preventDefault();
            
            const name = document.getElementById('name').value;
            const no_kampus = document.getElementById('no_kampus').value;
            const email = document.getElementById('email').value;
            const phone_number = document.getElementById('phone_number').value;
            const unsoed_faculty = document.getElementById('unsoed_faculty').value;
            const unsoed_major = document.getElementById('unsoed_major').value;
            const password = document.getElementById('password').value;
            const password_confirmation = document.getElementById('password_confirmation').value;

            if (password !== password_confirmation) {
                window.showToast('Konfirmasi password tidak cocok.', 'error');
                return;
            }

            const btnSubmit = document.getElementById('btn-submit');
            const btnText = document.getElementById('btn-text');
            const btnLoader = document.getElementById('btn-loader');

            btnSubmit.disabled = true;
            btnText.textContent = 'Mendaftar...';
            btnLoader.classList.remove('hidden');

            try {
                const response = await fetch('/api/v1/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name,
                        no_kampus,
                        email,
                        phone_number,
                        unsoed_faculty,
                        unsoed_major,
                        password,
                        password_confirmation
                    })
                });

                if (!response.ok && response.status === 404) {
                    throw new Error('Jalur rute API v1 tidak ditemukan di server (404).');
                }

                const result = await response.json();

                if (response.ok && result.token) {
                    localStorage.setItem('preloved_token', result.token);
                    localStorage.setItem('preloved_user', JSON.stringify(result.user));
                    
                    window.showToast('Registrasi Berhasil! Selamat datang.');
                    
                    setTimeout(() => {
                        window.location.href = "{{ route('home') }}";
                    }, 1000);
                    return; 
                } else {
                    window.showToast(result.message || 'Registrasi gagal. Periksa data Anda.', 'error');
                    
                    btnSubmit.disabled = false;
                    btnText.textContent = 'Daftar Akun Mahasiswa';
                    btnLoader.classList.add('hidden');
                    return; 
                }
            } catch (error) {
                console.log('Terjadi masalah internal server atau API offline, dialihkan ke simulasi lokal:', error.message);
                
                const mockUser = {
                    id: 100,
                    name: name,
                    email: email,
                    phone_number: phone_number,
                    unsoed_faculty: unsoed_faculty,
                    unsoed_major: unsoed_major,
                    avatar_url: 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=150&h=150&q=80',
                    rating_cache: 5.0,
                    role: 'student',
                    is_verified: true,
                    no_kampus: no_kampus
                };

                localStorage.setItem('preloved_token', 'mock_token_register_123');
                localStorage.setItem('preloved_user', JSON.stringify(mockUser));
                
                window.showToast('Registrasi Berhasil (Demo Mode - Offline)!');

                setTimeout(() => {
                    btnSubmit.disabled = false;
                    btnText.textContent = 'Daftar Akun Mahasiswa';
                    btnLoader.classList.add('hidden');
                    window.location.href = "{{ route('home') }}";
                }, 1000);
            }
        }
    </script>
</body>
</html>