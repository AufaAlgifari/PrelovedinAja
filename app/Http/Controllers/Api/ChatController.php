<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use App\Notifications\NewChatMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    // GET /chats — daftar kontak percakapan aktif
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        // Ambil seluruh chat room di mana user berpartisipasi
        $chats = Chat::with(['buyer:id,name,avatar_url', 'seller:id,name,avatar_url', 'product:id,title,image_urls', 'messages' => function ($q) {
            $q->latest();
        }])
        ->where('buyer_id', $userId)
        ->orWhere('seller_id', $userId)
        ->get();

        // Map and sort based on latest message
        $conversations = $chats->map(function ($chat) use ($userId) {
            $latestMsg = $chat->messages->first();
            $chat->latest_message = $latestMsg;
            // Identify target contact
            $chat->contact = $chat->buyer_id === $userId ? $chat->seller : $chat->buyer;
            return $chat;
        })
        ->sortByDesc(function ($chat) {
            return $chat->latest_message ? $chat->latest_message->created_at : $chat->created_at;
        });

        return response()->json($conversations->values());
    }

    // GET /chats/{userId} — riwayat percakapan dengan user tertentu
    public function show(Request $request, int $userId)
    {
        $currentUserId = $request->user()->id;
        
        // Ambil chat room yang bersangkutan
        $chat = Chat::between($currentUserId, $userId)
            ->first();

        if (!$chat) {
            return response()->json(['messages' => []]);
        }

        $messages = Message::with('sender:id,name,avatar_url')
            ->where('chat_id', $chat->id)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json(['chat_id' => $chat->id, 'messages' => $messages]);
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

        $senderId = $request->user()->id;
        $receiverId = $data['receiver_id'];
        $productId = $data['product_id'] ?? null;

        // Cek apakah chat room sudah ada
        $chatRoom = Chat::where(function ($q) use ($senderId, $receiverId) {
            $q->where('buyer_id', $senderId)->where('seller_id', $receiverId);
        })->orWhere(function ($q) use ($senderId, $receiverId) {
            $q->where('buyer_id', $receiverId)->where('seller_id', $senderId);
        });

        if ($productId) {
            $chatRoom = $chatRoom->where('product_id', $productId);
        }

        $chatRoom = $chatRoom->first();

        // Jika belum ada, buat baru
        if (!$chatRoom) {
            $chatRoom = Chat::create([
                'buyer_id'   => $senderId,
                'seller_id'  => $receiverId,
                'product_id' => $productId,
            ]);
        }

        // Buat baris pesan baru
        $message = Message::create([
            'chat_id'   => $chatRoom->id,
            'sender_id' => $senderId,
            'pesan'     => $data['message'], // Kolom 'pesan' di ERD
            'is_read'   => false,
        ]);

        // Set sender relation to avoid extra query
        $message->setRelation('sender', $request->user());

        // Kirim notifikasi ke penerima
        $receiver = User::find($receiverId);
        if ($receiver) {
            $receiver->notify(new NewChatMessageNotification($message));
        }

        return response()->json([
            'message' => 'Pesan terkirim.',
            'chat'    => $chatRoom->load(['buyer:id,name,avatar_url', 'seller:id,name,avatar_url', 'product:id,title']),
            'msg'     => $message->load('sender:id,name,avatar_url'),
        ], 201);
    }

    // PATCH /chats/{userId}/read — tandai semua pesan dari user sebagai sudah dibaca
    public function markAsRead(Request $request, int $userId)
    {
        $currentUserId = $request->user()->id;

        $chat = Chat::between($currentUserId, $userId)->first();

        if ($chat) {
            Message::where('chat_id', $chat->id)
                ->where('sender_id', $userId)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        return response()->json(['message' => 'Pesan ditandai sudah dibaca.']);
    }
}