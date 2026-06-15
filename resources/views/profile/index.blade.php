@extends('layouts.app')

@section('content')
<div class="min-h-[calc(100vh-80px)] py-12 px-4 sm:px-6 lg:px-8 bg-brand-50 transition-colors duration-300">
    <div class="max-w-2xl mx-auto bg-brand-100 rounded-3xl border border-brand-500/25 shadow-xl p-6 sm:p-10 relative overflow-hidden transition-colors duration-300">
        
        <!-- Background graphics -->
        <div class="absolute -top-24 -left-24 w-48 h-48 bg-brand-500/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-brand-600/5 rounded-full blur-3xl"></div>

        <div class="border-b border-brand-500/20 pb-5 mb-8 relative flex justify-between items-center text-brand-900">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight font-heading">Profil Saya</h1>
                <p class="text-xs text-brand-600 mt-1 font-medium">Kelola informasi kartu identitas mahasiswa dan detail kontak Anda.</p>
            </div>
            
            <div id="verified-badge-container">
                <!-- Filled via JS -->
            </div>
        </div>

        <form id="profile-form" class="space-y-6 relative text-brand-900" onsubmit="handleUpdateProfile(event)">
            @csrf
            
            <!-- Avatar Display & Edit -->
            <div class="flex flex-col sm:flex-row items-center gap-6 p-5 bg-brand-50/50 rounded-2xl border border-brand-500/10">
                <div class="relative group">
                    <img id="profile-avatar" class="h-20 w-20 rounded-full object-cover border-4 border-brand-500/50 shadow-md" 
                         src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=150&h=150&q=80">
                    <!-- Overlay klik -->
                    <label for="avatar-upload" class="absolute inset-0 flex items-center justify-center bg-black/40 rounded-full opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0"></path>
                        </svg>
                    </label>
                    <input type="file" id="avatar-upload" accept="image/*" class="hidden" onchange="handleAvatarUpload(event)">
                </div>

                <div class="space-y-1 text-center sm:text-left">
                    <p class="text-xs font-bold text-brand-600 uppercase tracking-wider">Foto Profil</p>
                    <p class="text-xs text-brand-600/70">JPG, PNG, atau GIF. Maks. 2MB.</p>
                    <label for="avatar-upload" class="inline-block mt-1 px-4 py-2 bg-brand-50 border border-brand-500/30 rounded-xl text-xs font-bold text-brand-600 hover:bg-brand-100 cursor-pointer transition">
                        Ganti Foto
                    </label>
                    <!-- Simpan base64 hasil upload -->
                    <input type="hidden" id="avatar_url">
                </div>
            </div>

            <!-- Profile Info Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label class="block text-xs font-bold text-brand-600 uppercase tracking-wider mb-2">Nama Lengkap</label>
                    <input type="text" id="name" required 
                           class="w-full px-4 py-3 bg-brand-50 border border-brand-500/30 rounded-2xl text-sm focus:border-brand-600 focus:outline-none text-brand-900">
                </div>

                <!-- NIM / No Kampus -->
                <div>
                    <label class="block text-xs font-bold text-brand-600 uppercase tracking-wider mb-2">NIM / Nomor Identitas Kampus</label>
                    <input type="text" id="no_camp" disabled 
                           class="w-full px-4 py-3 bg-brand-50 border border-brand-500/15 rounded-2xl text-sm text-brand-900/60 font-bold uppercase cursor-not-allowed">
                </div>

                <!-- Faculty -->
                <div>
                    <label class="block text-xs font-bold text-brand-600 uppercase tracking-wider mb-2">Fakultas</label>
                    <input type="text" id="faculty" disabled 
                           class="w-full px-4 py-3 bg-brand-50 border border-brand-500/15 rounded-2xl text-sm text-brand-900/60 cursor-not-allowed">
                </div>

                <!-- Major -->
                <div>
                    <label class="block text-xs font-bold text-brand-600 uppercase tracking-wider mb-2">Jurusan</label>
                    <input type="text" id="major" disabled 
                           class="w-full px-4 py-3 bg-brand-50 border border-brand-500/15 rounded-2xl text-sm text-brand-900/60 cursor-not-allowed">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-xs font-bold text-brand-600 uppercase tracking-wider mb-2">Email Kampus</label>
                    <input type="email" id="email" disabled 
                           class="w-full px-4 py-3 bg-brand-50 border border-brand-500/15 rounded-2xl text-sm text-brand-900/60 cursor-not-allowed">
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-xs font-bold text-brand-600 uppercase tracking-wider mb-2">Nomor WhatsApp / HP</label>
                    <input type="text" id="phone_number" required 
                           class="w-full px-4 py-3 bg-brand-50 border border-brand-500/30 rounded-2xl text-sm focus:border-brand-600 focus:outline-none text-brand-900">
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-6 border-t border-brand-500/20 flex items-center justify-end gap-3">
                <a href="{{ route('home') }}" class="px-6 py-3.5 bg-brand-50 hover:bg-brand-100 text-brand-600 border border-brand-500/20 font-bold text-xs rounded-2xl transition">
                    Batal
                </a>
                <button type="submit" id="btn-save" class="px-8 py-3.5 text-brand-50 bg-brand-600 hover:bg-brand-900 font-bold text-xs rounded-2xl shadow-lg transition-all flex items-center justify-center gap-2">
                    <span id="btn-text">Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function handleAvatarUpload(event) {
        const file = event.target.files[0];
        if (!file) return;

        if (file.size > 2 * 1024 * 1024) {
            window.showToast('Ukuran foto maksimal 2MB.', 'error');
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            const base64 = e.target.result;
            document.getElementById('profile-avatar').src = base64;
            document.getElementById('avatar_url').value = base64;
        };
        reader.readAsDataURL(file);
    }

    function loadUserProfile() {
        const userJson = localStorage.getItem('preloved_user');
        if (!userJson) {
            window.showToast('Silakan masuk terlebih dahulu.', 'error');
            window.location.href = "{{ route('login') }}";
            return;
        }

        const user = JSON.parse(userJson);

        document.getElementById('name').value = user.name || '';
        document.getElementById('no_camp').value = user.no_kampus || 'Belum Diisi';
        document.getElementById('email').value = user.email || '';
        document.getElementById('phone_number').value = user.phone_number || '';
        document.getElementById('faculty').value = user.unsoed_faculty || 'Umum';
        document.getElementById('major').value = user.unsoed_major || 'UNSOED';
        document.getElementById('avatar_url').value = user.avatar_url || '';

        const avatarSrc = user.avatar_url || 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=150&h=150&q=80';
        document.getElementById('profile-avatar').src = avatarSrc;

        const badgeContainer = document.getElementById('verified-badge-container');
        if (user.is_verified) {
            badgeContainer.innerHTML = `<span class="bg-[#7A4A10] text-[#FBF6EC] text-xs font-bold px-3 py-1.5 rounded-full border border-brand-500/20">✓ Verified Student</span>`;
        } else {
            badgeContainer.innerHTML = `<span class="bg-amber-100 text-amber-700 text-xs font-bold px-3 py-1.5 rounded-full border border-amber-200">Pending Verification</span>`;
        }
    }

    async function handleUpdateProfile(e) {
        e.preventDefault();

        const name = document.getElementById('name').value.trim();
        const phone_number = document.getElementById('phone_number').value.trim();
        const avatar_url = document.getElementById('avatar_url').value;
        const token = localStorage.getItem('preloved_token');

        const btn = document.getElementById('btn-save');
        const btnText = document.getElementById('btn-text');
        btn.disabled = true;
        btnText.textContent = 'Menyimpan...';

        // Selalu update localStorage dulu, apapun kondisi API
        const user = JSON.parse(localStorage.getItem('preloved_user') || '{}');
        user.name = name;
        user.phone_number = phone_number;
        if (avatar_url) user.avatar_url = avatar_url;

        try {
            localStorage.setItem('preloved_user', JSON.stringify(user));
        } catch (storageError) {
            // Kalau base64 terlalu besar, simpan tanpa foto
            console.warn('Storage penuh, menyimpan tanpa foto baru.');
            const userWithoutAvatar = { ...user };
            delete userWithoutAvatar.avatar_url;
            localStorage.setItem('preloved_user', JSON.stringify(userWithoutAvatar));
            window.showToast('Profil disimpan, tapi foto terlalu besar untuk disimpan lokal.', 'error');
            btn.disabled = false;
            btnText.textContent = 'Simpan Perubahan';
            return;
        }

        // Coba kirim ke API
        try {
            const response = await fetch('/api/v1/me', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({ name, phone_number, avatar_url: user.avatar_url })
            });

            if (response.ok) {
                const result = await response.json();
                localStorage.setItem('preloved_user', JSON.stringify(result.user));
            }
        } catch (error) {
            console.log('API offline, data sudah tersimpan lokal.');
        }

        // Sync navbar/header dan tampilkan hasil
        if (typeof window.syncAuthHeader === 'function') {
            window.syncAuthHeader();
        }

        window.showToast('Profil berhasil diperbarui!');
        btn.disabled = false;
        btnText.textContent = 'Simpan Perubahan';
    }

    window.addEventListener('DOMContentLoaded', () => {
        loadUserProfile();
    });
</script>
@endsection