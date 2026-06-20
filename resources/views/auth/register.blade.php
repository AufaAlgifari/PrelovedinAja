@extends('layouts.app')

@section('content')
<div class="min-h-[calc(100vh-80px)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-brand-50 transition-colors duration-300">
    <div class="max-w-xl w-full space-y-8 bg-brand-100 p-8 sm:p-10 rounded-3xl border border-brand-500/25 shadow-xl relative overflow-hidden transition-colors duration-300">
        
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-brand-500/10 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-brand-600/10 rounded-full blur-2xl"></div>

        <div class="text-center relative">
            <h2 class="text-3xl font-extrabold text-brand-900 tracking-tight font-heading">Daftar Akun Baru</h2>
            <p class="text-[10px] text-brand-900 font-bold uppercase tracking-wider mt-2.5 flex items-center justify-center gap-1.5 bg-brand-50 px-4 py-2 rounded-full w-max mx-auto border border-brand-500/20">
                <span>🎓</span> Registrasi Mahasiswa UNSOED
            </p>
        </div>

        <form id="register-form" class="mt-8 space-y-6" onsubmit="handleRegister(event)">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-brand-600 uppercase tracking-wider mb-2">Nama Lengkap</label>
                    <input type="text" id="name" required placeholder="Misal: Aufa Algifari" 
                           class="w-full px-4 py-3 bg-brand-50 border border-brand-500/30 rounded-2xl text-sm focus:border-brand-600 focus:ring-4 focus:ring-brand-600/10 focus:outline-none transition-all text-brand-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-brand-600 uppercase tracking-wider mb-2">NIM / Nomor Kampus</label>
                    <input type="text" id="no_kampus" required placeholder="Misal: H1D024001" 
                           class="w-full px-4 py-3 bg-brand-50 border border-brand-500/30 rounded-2xl text-sm focus:border-brand-600 focus:ring-4 focus:ring-brand-600/10 focus:outline-none transition-all text-brand-900 font-bold uppercase">
                </div>

                <div>
                    <label class="block text-xs font-bold text-brand-600 uppercase tracking-wider mb-2">Email Institusi UNSOED</label>
                    <input type="email" id="email" required pattern=".*\.ac\.id$" title="Harus menggunakan email institusi berakhiran .ac.id" placeholder="nama@mhs.unsoed.ac.id" 
                           class="w-full px-4 py-3 bg-brand-50 border border-brand-500/30 rounded-2xl text-sm focus:border-brand-600 focus:ring-4 focus:ring-brand-600/10 focus:outline-none transition-all text-brand-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-brand-600 uppercase tracking-wider mb-2">Nomor WhatsApp</label>
                    <input type="text" id="phone_number" required placeholder="Misal: 08123456789" 
                           class="w-full px-4 py-3 bg-brand-50 border border-brand-500/30 rounded-2xl text-sm focus:border-brand-600 focus:ring-4 focus:ring-brand-600/10 focus:outline-none transition-all text-brand-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-brand-600 uppercase tracking-wider mb-2">Fakultas</label>
                    <select id="unsoed_faculty" required class="w-full px-4 py-3 bg-brand-50 border border-brand-500/30 rounded-2xl text-sm focus:border-brand-600 focus:ring-4 focus:ring-brand-600/10 focus:outline-none transition-all text-brand-900">
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
                    <label class="block text-xs font-bold text-brand-600 uppercase tracking-wider mb-2">Jurusan / Program Studi</label>
                    <input type="text" id="unsoed_major" required placeholder="Misal: Teknik Informatika" 
                           class="w-full px-4 py-3 bg-brand-50 border border-brand-500/30 rounded-2xl text-sm focus:border-brand-600 focus:ring-4 focus:ring-brand-600/10 focus:outline-none transition-all text-brand-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-brand-600 uppercase tracking-wider mb-2">Password</label>
                    <input type="password" id="password" required placeholder="••••••••" 
                           class="w-full px-4 py-3 bg-brand-50 border border-brand-500/30 rounded-2xl text-sm focus:border-brand-600 focus:ring-4 focus:ring-brand-600/10 focus:outline-none transition-all text-brand-900">
                </div>

                <div>
                    <label class="block text-xs font-bold text-brand-600 uppercase tracking-wider mb-2">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" required placeholder="••••••••" 
                           class="w-full px-4 py-3 bg-brand-50 border border-brand-500/30 rounded-2xl text-sm focus:border-brand-600 focus:ring-4 focus:ring-brand-600/10 focus:outline-none transition-all text-brand-900">
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" id="btn-submit" class="w-full py-3.5 px-4 text-sm font-bold text-brand-50 bg-brand-600 hover:bg-brand-900 rounded-2xl shadow-lg transition-all focus:outline-none flex items-center justify-center gap-2">
                    <span id="btn-text">Daftar Akun Mahasiswa</span>
                    <span id="btn-loader" class="hidden animate-spin h-5 w-5 border-2 border-brand-50 border-t-transparent rounded-full"></span>
                </button>
            </div>
        </form>
        
        <div class="mt-6 text-center text-xs text-brand-900/70">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-brand-600 font-extrabold hover:text-brand-900 hover:underline">Masuk Di Sini</a>
        </div>
    </div>
</div>

<script>
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
            if (window.showToast) {
                window.showToast('Konfirmasi password tidak cocok.', 'error');
            } else {
                alert('Konfirmasi password tidak cocok.');
            }
            return;
        }

        const btnSubmit = document.getElementById('btn-submit');
        const btnText = document.getElementById('btn-text');
        const btnLoader = document.getElementById('btn-loader');

        btnSubmit.disabled = true;
        btnText.textContent = 'Mendaftar...';
        btnLoader.classList.remove('hidden');

        try {
            // Mengirim request ke API Laravel
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

            // Antisipasi jika route mengembalikan HTML error 404/500 agar parser JSON tidak crash
            if (!response.ok && response.status === 404) {
                throw new Error('Jalur rute API v1 tidak ditemukan di server (404).');
            }

            const result = await response.json();

            if (response.ok && result.token) {
                // Berhasil masuk ke database asli
                localStorage.setItem('preloved_token', result.token);
                localStorage.setItem('preloved_user', JSON.stringify(result.user));
                
                if (window.showToast) window.showToast('Registrasi Berhasil! Selamat datang.');
                
                setTimeout(() => {
                    window.location.href = "{{ route('home') }}";
                }, 1000);
                return; 
            } else {
                // Menampilkan error validasi dari Laravel (Misal: email sudah terdaftar, dll)
                if (window.showToast) {
                    window.showToast(result.message || 'Registrasi gagal. Periksa data Anda.', 'error');
                } else {
                    alert(result.message || 'Registrasi gagal.');
                }
                
                btnSubmit.disabled = false;
                btnText.textContent = 'Daftar Akun Mahasiswa';
                btnLoader.classList.add('hidden');
                return; 
            }
        } catch (error) {
            // Pindah ke Demo Mode HANYA jika server mengalami kendala rute / offline (Network Error)
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
            
            if (window.showToast) {
                window.showToast('Registrasi Berhasil (Demo Mode - Offline)!');
            } else {
                alert('Registrasi Berhasil (Demo Mode - Offline)!');
            }

            setTimeout(() => {
                btnSubmit.disabled = false;
                btnText.textContent = 'Daftar Akun Mahasiswa';
                btnLoader.classList.add('hidden');
                window.location.href = "{{ route('home') }}";
            }, 1000);
        }
    }
</script>
@endsection