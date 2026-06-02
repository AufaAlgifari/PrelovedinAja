<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    // GET /chats — daftar kontak percakapan aktif
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        // Ambil pesan terakhir tiap percakapan unik
        $conversations = Chat::with(['sender:id,name,avatar_url', 'receiver:id,name,avatar_url', 'product:id,title'])
            ->where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($chat) use ($userId) {
                // Kunci grup = ID lawan bicara
                return $chat->sender_id === $userId
                    ? $chat->receiver_id
                    : $chat->sender_id;
            })
            ->map(fn($group) => $group->first()); // Ambil pesan terakhir tiap grup

        return response()->json($conversations->values());
    }

    // GET /chats/{userId} — riwayat percakapan dengan user tertentu
    public function show(Request $request, int $userId)
    {
        $chats = Chat::with(['sender:id,name,avatar_url', 'product:id,title,image_urls'])
            ->conversation($request->user()->id, $userId)
            ->paginate(30);

        return response()->json($chats);
    }

    // POST /chats — kirim pesan
    public function store(Request $request)
    {
        $data = $request->validate([
            'receiver_id' => 'required|integer|exists:users,id|different:' . $request->user()->id,
            'product_id'  => 'nullable|integer|exists:products,id',
            'message'     => 'required|string|max:1000',
        ], [
            'receiver_id.different' => 'Kamu tidak bisa mengirim pesan ke diri sendiri.',
        ]);

        $chat = Chat::create([
            'sender_id'   => $request->user()->id,
            'receiver_id' => $data['receiver_id'],
            'product_id'  => $data['product_id'] ?? null,
            'message'     => $data['message'],
            'is_read'     => false,
        ]);

        // TODO: broadcast ke Pusher/Reverb untuk real-time
        // broadcast(new MessageSent($chat))->toOthers();

        return response()->json([
            'message' => 'Pesan terkirim.',
            'chat'    => $chat->load(['sender:id,name,avatar_url', 'product:id,title']),
        ], 201);
    }

    // PATCH /chats/{userId}/read — tandai semua pesan dari user sebagai sudah dibaca
    public function markAsRead(Request $request, int $userId)
    {
        Chat::where('sender_id', $userId)
            ->where('receiver_id', $request->user()->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['message' => 'Pesan ditandai sudah dibaca.']);
    }
}