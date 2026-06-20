<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the notifications.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $unreadOnly = $request->boolean('unread');

        $query = $unreadOnly ? $user->unreadNotifications() : $user->notifications();

        // Get latest 50 notifications
        $notifications = $query->latest()->limit(50)->get();

        return response()->json([
            'status' => 'success',
            'data' => $notifications
        ]);
    }

    /**
     * Mark a specific notification as read.
     */
    public function markAsRead(Request $request, string $id)
    {
        $notification = $request->user()->unreadNotifications()->where('id', $id)->first();

        if (!$notification) {
            return response()->json([
                'status' => 'error',
                'message' => 'Notification not found or already read.'
            ], 404);
        }

        $notification->markAsRead();

        return response()->json([
            'status' => 'success',
            'message' => 'Notification marked as read.'
        ]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return response()->json([
            'status' => 'success',
            'message' => 'All notifications marked as read.'
        ]);
    }
}
