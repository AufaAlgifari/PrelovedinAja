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
        ]);

        $user = User::create($data);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registrasi berhasil.',
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
        ]);

        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        // Hapus token lama, buat token baru (single session)
        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

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
            'avatar_url'     => 'sometimes|nullable|string|url',
            'password'       => 'sometimes|string|min:8|confirmed',
        ]);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return response()->json([
            'message' => 'Profil berhasil diperbarui.',
            'user'    => $user->fresh(),
        ]);
    }
}