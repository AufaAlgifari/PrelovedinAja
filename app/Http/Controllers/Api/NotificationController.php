<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the notifications.
     * Returns all notifications with proper structure.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Get latest 50 notifications (read + unread)
        $notifications = $user->notifications()->latest()->limit(50)->get();

        $unreadCount = $user->unreadNotifications()->count();

        return response()->json([
            'status'       => 'success',
            'unread_count' => $unreadCount,
            'data'         => $notifications,
        ]);
    }

    /**
     * Mark a specific notification as read.
     */
    public function markAsRead(Request $request, string $id)
    {
        // Try to find in unread first, fallback to all notifications
        $notification = $request->user()->notifications()->where('id', $id)->first();

        if (!$notification) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Notification not found.',
            ], 404);
        }

        if (!$notification->read_at) {
            $notification->markAsRead();
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Notification marked as read.',
        ]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(Request $request)
    {
        $unread = $request->user()->unreadNotifications;
        if ($unread->isNotEmpty()) {
            $unread->markAsRead();
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'All notifications marked as read.',
        ]);
    }
}
