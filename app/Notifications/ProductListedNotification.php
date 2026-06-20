<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class ProductListedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $product;

    /**
     * Create a new notification instance.
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $formattedPrice = number_format($this->product->price, 0, ',', '.');
        return [
            'title' => 'Produk Berhasil Diiklankan',
            'message' => "Selamat, produk Anda \"{$this->product->title}\" telah berhasil diiklankan dengan harga Rp{$formattedPrice}.",
            'product_id' => $this->product->id,
            'product_name' => $this->product->title,
            'price' => $this->product->price,
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
