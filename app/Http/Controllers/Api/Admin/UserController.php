<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->select([
            'id', 'name', 'email', 'unsoed_faculty', 'unsoed_major',
            'role', 'is_verified', 'status', 'rating_cache', 'created_at',
        ]);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->latest()->paginate($request->get('per_page', 15));

        return response()->json($users);
    }

    public function suspend(Request $request, User $user)
    {
        $validated = $request->validate([
            'reason' => ['required', 'string', 'min:5', 'max:500'],
        ]);

        if ($user->role === 'admin') {
            return response()->json([
                'message' => 'Tidak dapat menangguhkan akun administrator.'
            ], 422);
        }

        $user->update([
            'status'          => 'suspended',
            'suspend_reason'  => $validated['reason'],
            'suspended_at'    => now(),
        ]);

        \App\Models\Report::where('reported_user_id', $user->id)
            ->where('status', 'Pending')
            ->update(['status' => 'Suspended']);

        AuditLogController::record(
            $request->user()->id,
            'suspend_user',
            'User',
            $user->id,
            "Menangguhkan akun \"{$user->name}\" ({$user->email}). Alasan: {$validated['reason']}"
        );

        return response()->json(['message' => 'Akun berhasil ditangguhkan.', 'user' => $user]);
    }

    public function unsuspend(Request $request, User $user)
    {
        $user->update([
            'status'          => 'active',
            'suspend_reason'  => null,
            'suspended_at'    => null,
        ]);

        AuditLogController::record(
            $request->user()->id,
            'unsuspend_user',
            'User',
            $user->id,
            "Mengaktifkan kembali akun \"{$user->name}\" ({$user->email})."
        );

        return response()->json(['message' => 'Akun berhasil diaktifkan kembali.', 'user' => $user]);
    }
}