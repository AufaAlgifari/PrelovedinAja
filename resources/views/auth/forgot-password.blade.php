<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lupa Password - Preloved.in Aja</title>
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

        <!-- Back Link to Login -->
        <div class="absolute top-4 left-4 z-10">
            <a href="{{ route('login') }}" class="inline-flex items-center gap-1 text-[10px] font-bold text-[#7A4A10] hover:text-[#2E1A06] transition bg-white/50 px-2.5 py-1 rounded-full border border-[#D4A017]/20">
                Kembali ke Login
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
            <h2 class="text-3xl font-extrabold text-[#2E1A06] tracking-tight font-heading">Lupa Password</h2>
            <p id="sub-title" class="text-xs text-[#2E1A06]/80 mt-2 max-w-[280px] mx-auto">
                Masukkan email institusi Anda untuk mendapatkan kode verifikasi reset password.
            </p>
        </div>

        <!-- STEP 1: Request Verification Code -->
        <div id="step-1-container" class="mt-6 space-y-4">
            <form id="request-form" class="space-y-4" onsubmit="handleRequestOtp(event)">
                @csrf
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

                <div class="pt-2">
                    <button type="submit" id="btn-request-submit" class="w-full py-3.5 px-4 text-sm font-bold text-[#FBF6EC] bg-[#7A4A10] hover:bg-[#5f390c] rounded-2xl shadow-lg transition-all focus:outline-none flex items-center justify-center gap-2">
                        <span id="btn-request-text">Kirim Kode Verifikasi</span>
                        <span id="btn-request-loader" class="hidden animate-spin h-5 w-5 border-2 border-[#FBF6EC] border-t-transparent rounded-full"></span>
                    </button>
                </div>
            </form>
        </div>

        <!-- STEP 2: Enter OTP & New Password -->
        <div id="step-2-container" class="mt-6 space-y-4 hidden">
            <!-- Simulated OTP info banner -->
            <div id="demo-banner" class="bg-amber-50 border border-amber-200 rounded-xl p-3 text-xs text-amber-800 font-medium space-y-1">
                <div class="flex items-center gap-1.5 font-bold text-amber-900">
                    <span>💡</span> Info Simulasi Kampus:
                </div>
                <p>Kode verifikasi telah dikirim. Masukkan kode berikut untuk melanjutkan:</p>
                <div class="mt-1 text-center bg-amber-100 py-1.5 rounded font-mono text-sm tracking-widest font-extrabold text-[#7A4A10]" id="otp-display-value">
                    123456
                </div>
            </div>

            <form id="reset-form" class="space-y-4" onsubmit="handleResetPassword(event)">
                @csrf
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-[#7A4A10] uppercase tracking-wider mb-1">Email</label>
                        <div class="text-sm font-semibold text-[#2E1A06] bg-[#FBF6EC]/50 px-3 py-2 rounded border border-[#D4A017]/10" id="display-email">
                            -
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#7A4A10] uppercase tracking-wider mb-1">Kode Verifikasi (OTP)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-[#7A4A10]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </span>
                            <input type="text" name="otp" id="otp" required maxlength="6" pattern="^[0-9]{6}$" placeholder="Masukkan 6 digit kode"
                                   class="w-full pl-10 pr-4 py-2.5 bg-[#FBF6EC] border border-[#D4A017]/30 rounded-[5px] text-sm focus:border-[#7A4A10] focus:ring-4 focus:ring-[#7A4A10]/10 focus:outline-none transition-all text-[#2E1A06] font-mono tracking-widest text-center">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#7A4A10] uppercase tracking-wider mb-1">Password Baru</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-[#7A4A10]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </span>
                            <input type="password" name="password" id="password" required minlength="8" placeholder="Minimal 8 karakter" 
                                   class="w-full pl-10 pr-4 py-2.5 bg-[#FBF6EC] border border-[#D4A017]/30 rounded-[5px] text-sm focus:border-[#7A4A10] focus:ring-4 focus:ring-[#7A4A10]/10 focus:outline-none transition-all text-[#2E1A06]">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#7A4A10] uppercase tracking-wider mb-1">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-[#7A4A10]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </span>
                            <input type="password" name="password_confirmation" id="password_confirmation" required minlength="8" placeholder="Ulangi password baru" 
                                   class="w-full pl-10 pr-4 py-2.5 bg-[#FBF6EC] border border-[#D4A017]/30 rounded-[5px] text-sm focus:border-[#7A4A10] focus:ring-4 focus:ring-[#7A4A10]/10 focus:outline-none transition-all text-[#2E1A06]">
                        </div>
                    </div>
                </div>

                <div class="pt-2 flex gap-3">
                    <button type="button" onclick="setStep(1)" class="w-1/3 py-3.5 px-4 text-sm font-bold text-[#7A4A10] bg-[#FBF6EC] hover:bg-[#ebdcc0] rounded-2xl shadow border border-[#7A4A10]/30 transition-all focus:outline-none text-center">
                        Batal
                    </button>
                    <button type="submit" id="btn-reset-submit" class="w-2/3 py-3.5 px-4 text-sm font-bold text-[#FBF6EC] bg-[#7A4A10] hover:bg-[#5f390c] rounded-2xl shadow-lg transition-all focus:outline-none flex items-center justify-center gap-2">
                        <span id="btn-reset-text">Simpan Password</span>
                        <span id="btn-reset-loader" class="hidden animate-spin h-5 w-5 border-2 border-[#FBF6EC] border-t-transparent rounded-full"></span>
                    </button>
                </div>
            </form>
        </div>
        
        <div class="mt-5 text-center text-xs text-[#2E1A06]/70">
            Kembali ke halaman <a href="{{ route('login') }}" class="text-[#7A4A10] font-extrabold hover:text-[#2E1A06] hover:underline">Masuk Akun</a>
        </div>
    </div>

    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2 pointer-events-none"></div>

    <script>
        // Global variables
        let submittedEmail = '';
        let activeOtp = '123456';
        let isDemoMode = false;

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

        function setStep(step) {
            const subtitle = document.getElementById('sub-title');
            if (step === 1) {
                document.getElementById('step-1-container').classList.remove('hidden');
                document.getElementById('step-2-container').classList.add('hidden');
                subtitle.textContent = "Masukkan email institusi Anda untuk mendapatkan kode verifikasi reset password.";
            } else {
                document.getElementById('step-1-container').classList.add('hidden');
                document.getElementById('step-2-container').classList.remove('hidden');
                document.getElementById('display-email').textContent = submittedEmail;
                document.getElementById('otp-display-value').textContent = activeOtp;
                subtitle.textContent = "Masukkan kode verifikasi dan atur ulang password baru Anda.";
            }
        }

        async function handleRequestOtp(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            const btnSubmit = document.getElementById('btn-request-submit');
            const btnText = document.getElementById('btn-request-text');
            const btnLoader = document.getElementById('btn-request-loader');

            btnSubmit.disabled = true;
            btnText.textContent = 'Memproses...';
            btnLoader.classList.remove('hidden');

            try {
                const response = await fetch('/api/v1/forgot-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ email })
                });

                const result = await response.json();

                if (response.ok) {
                    submittedEmail = email;
                    activeOtp = result.demo_otp || '123456';
                    isDemoMode = false;
                    
                    window.showToast(result.message || 'Kode verifikasi telah dikirim!');
                    setTimeout(() => {
                        btnSubmit.disabled = false;
                        btnText.textContent = 'Kirim Kode Verifikasi';
                        btnLoader.classList.add('hidden');
                        setStep(2);
                    }, 800);
                } else {
                    window.showToast(result.message || result.errors?.email?.[0] || 'Email tidak terdaftar.', 'error');
                    btnSubmit.disabled = false;
                    btnText.textContent = 'Kirim Kode Verifikasi';
                    btnLoader.classList.add('hidden');
                }
            } catch (error) {
                console.log('Database offline atau jaringan bermasalah, mengaktifkan mode demo lokal:', error);
                
                // Fallback to local demo checking inside localStorage
                submittedEmail = email;
                activeOtp = '123456';
                isDemoMode = true;

                window.showToast('Demo Mode: Kode dikirim (gunakan 123456)', 'info');
                setTimeout(() => {
                    btnSubmit.disabled = false;
                    btnText.textContent = 'Kirim Kode Verifikasi';
                    btnLoader.classList.add('hidden');
                    setStep(2);
                }, 800);
            }
        }

        async function handleResetPassword(e) {
            e.preventDefault();

            const otp = document.getElementById('otp').value;
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            const btnSubmit = document.getElementById('btn-reset-submit');
            const btnText = document.getElementById('btn-reset-text');
            const btnLoader = document.getElementById('btn-reset-loader');

            if (password !== passwordConfirmation) {
                window.showToast('Konfirmasi password baru tidak cocok.', 'error');
                return;
            }

            btnSubmit.disabled = true;
            btnText.textContent = 'Menyimpan...';
            btnLoader.classList.remove('hidden');

            if (isDemoMode) {
                // Simulating locally in localStorage
                setTimeout(() => {
                    if (otp !== activeOtp) {
                        window.showToast('Kode verifikasi salah.', 'error');
                        btnSubmit.disabled = false;
                        btnText.textContent = 'Simpan Password';
                        btnLoader.classList.add('hidden');
                        return;
                    }

                    // Check if there is a mock user registered in localStorage
                    let mockUser = localStorage.getItem('preloved_user');
                    if (mockUser) {
                        try {
                            let userObj = JSON.parse(mockUser);
                            if (userObj.email === submittedEmail) {
                                userObj.password = password; // update client-side simulation
                                localStorage.setItem('preloved_user', JSON.stringify(userObj));
                            }
                        } catch (e) {
                            console.error(e);
                        }
                    }

                    window.showToast('Password berhasil diperbarui (Simulasi Demo)!');
                    setTimeout(() => {
                        window.location.href = "{{ route('login') }}";
                    }, 1200);
                }, 800);
                return;
            }

            try {
                const response = await fetch('/api/v1/reset-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        email: submittedEmail,
                        otp,
                        password,
                        password_confirmation: passwordConfirmation
                    })
                });

                const result = await response.json();

                if (response.ok) {
                    window.showToast(result.message || 'Password berhasil diperbarui.');
                    setTimeout(() => {
                        window.location.href = "{{ route('login') }}";
                    }, 1200);
                } else {
                    window.showToast(result.message || result.errors?.otp?.[0] || 'Gagal mereset password.', 'error');
                    btnSubmit.disabled = false;
                    btnText.textContent = 'Simpan Password';
                    btnLoader.classList.add('hidden');
                }
            } catch (error) {
                window.showToast('Terjadi kesalahan jaringan atau server.', 'error');
                btnSubmit.disabled = false;
                btnText.textContent = 'Simpan Password';
                btnLoader.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
