<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // POST /register
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'no_kampus'      => 'required|string|max:50|unique:users,no_kampus', // Ditambahkan agar data NIM masuk database
            'email'          => [
                'required',
                'email',
                'unique:users,email',
                // Hanya email institusi .ac.id
                'regex:/^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.ac\.id$/',
            ],
            'password'       => 'required|string|min:8|confirmed',
            'phone_number'   => 'nullable|string|max:20',
            'unsoed_faculty' => 'nullable|string|max:255',
            'unsoed_major'   => 'nullable|string|max:255',
        ], [
            'email.regex' => 'Email harus menggunakan domain institusi (.ac.id).',
            'no_kampus.unique' => 'NIM / Nomor Kampus sudah terdaftar.',
        ]);

        // Enkripsi password sebelum disimpan ke database
        $data['password'] = Hash::make($data['password']);

        // Simpan data ke tabel users
        $user = User::create($data);

        // Memicu pengiriman email verifikasi bawaan Laravel
        event(new \Illuminate\Auth\Events\Registered($user));

        // Sync web session login
        auth('web')->login($user);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registrasi berhasil. Silakan cek email Anda untuk link verifikasi.',
            'token'   => $token,
            'user'    => $user,
        ], 201);
    }

    // POST /login
    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
            'remember' => 'required|accepted',
        ], [
            'remember.accepted' => 'Centang ingat saya',
        ]);

        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        // Sync web session login
        auth('web')->login($user, true);

        return response()->json([
            'message' => 'Login berhasil.',
            'token'   => $token,
            'user'    => $user,
        ]);
    }

    // POST /logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        // Sync web session logout
        auth('web')->logout();

        return response()->json(['message' => 'Logout berhasil.']);
    }

    // GET /me
    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    // PUT /me
    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name'           => 'sometimes|string|max:255',
            'phone_number'   => 'sometimes|nullable|string|max:20',
            'unsoed_faculty' => 'sometimes|nullable|string|max:255',
            'unsoed_major'   => 'sometimes|nullable|string|max:255',
            'avatar_url'     => 'sometimes|nullable|string',
            'password'       => 'sometimes|string|min:8|confirmed',
        ]);

        if (isset($data['avatar_url']) && str_starts_with($data['avatar_url'], 'data:image/')) {
            try {
                $base64 = $data['avatar_url'];
                $position = strpos($base64, ',');
                $header = substr($base64, 0, $position);
                $dataStr = substr($base64, $position + 1);

                preg_match('/data:image\/(.*?);/', $header, $matches);
                $ext = $matches[1] ?? 'png';
                if ($ext === 'jpeg') $ext = 'jpg';

                $fileData = base64_decode($dataStr);
                $fileName = 'avatar_' . $user->id . '_' . time() . '.' . $ext;

                $dir = public_path('uploads/avatars');
                if (!file_exists($dir)) {
                    mkdir($dir, 0755, true);
                }
                file_put_contents($dir . '/' . $fileName, $fileData);

                $data['avatar_url'] = asset('uploads/avatars/' . $fileName);
            } catch (\Exception $e) {
                unset($data['avatar_url']);
            }
        }

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return response()->json([
            'message' => 'Profil berhasil diperbarui.',
            'user'    => $user->fresh(),
        ]);
    }

    // POST /forgot-password
    public function forgotPassword(Request $request)
    {
        $data = $request->validate([
            'email' => [
                'required',
                'email',
                // Hanya email institusi .ac.id
                'regex:/^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.ac\.id$/',
            ],
        ], [
            'email.regex' => 'Email harus menggunakan domain institusi (.ac.id).',
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['Email tidak terdaftar.'],
            ]);
        }

        // Generate 6-digit OTP
        $otp = (string) rand(100000, 999999);

        // Save to user
        $user->update([
            'verification_token' => $otp,
            'token_expired_at' => now()->addMinutes(15),
        ]);

        \Illuminate\Support\Facades\Log::info("Simulasi OTP Lupa Password untuk {$user->email}: {$otp}");

        return response()->json([
            'message' => 'Kode verifikasi telah dikirim ke email Anda.',
            'demo_otp' => $otp, // Untuk mempermudah pengujian / demo tanpa cek file log
        ]);
    }

    // POST /reset-password
    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'email'                 => 'required|email',
            'otp'                   => 'required|string|size:6',
            'password'              => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['Email tidak ditemukan.'],
            ]);
        }

        if ($user->verification_token !== $data['otp'] || !$user->token_expired_at || $user->token_expired_at->isPast()) {
            throw ValidationException::withMessages([
                'otp' => ['Kode verifikasi salah atau telah kedaluwarsa.'],
            ]);
        }

        // Update password and clear verification token
        $user->update([
            'password' => Hash::make($data['password']),
            'verification_token' => null,
            'token_expired_at' => null,
        ]);

        return response()->json([
            'message' => 'Password berhasil diperbarui. Silakan masuk kembali.',
        ]);
    }
}