<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewChatMessageNotification extends Notification
{
    use Queueable;

    protected $message;

    /**
     * Create a new notification instance.
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $senderName = $this->message->sender ? $this->message->sender->name : 'Seseorang';
        $preview = mb_strlen($this->message->pesan) > 60
            ? mb_substr($this->message->pesan, 0, 60) . '...'
            : $this->message->pesan;

        return [
            'type'        => 'new_message',
            'title'       => 'Pesan Baru dari ' . $senderName,
            'message'     => $preview,
            'sender_id'   => $this->message->sender_id,
            'sender_name' => $senderName,
            'chat_id'     => $this->message->chat_id,
            'pesan'       => $this->message->pesan,
            'url'         => '/chat?contact_id=' . $this->message->sender_id,
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'id' => $this->id,
            'type' => static::class,
            'data' => $this->toArray($notifiable),
            'read_at' => null,
            'created_at' => now()->toIso8601String(),
        ]);
    }
}
