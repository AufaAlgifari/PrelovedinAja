<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class CartProductPriceChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $product;
    protected $oldPrice;
    protected $newPrice;

    /**
     * Create a new notification instance.
     */
    public function __construct(Product $product, $oldPrice, $newPrice)
    {
        $this->product = $product;
        $this->oldPrice = $oldPrice;
        $this->newPrice = $newPrice;
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
        $formattedOld = number_format($this->oldPrice, 0, ',', '.');
        $formattedNew = number_format($this->newPrice, 0, ',', '.');
        return [
            'title' => 'Harga Produk Berubah',
            'message' => "Produk \"{$this->product->title}\" di keranjang Anda mengalami perubahan harga dari Rp{$formattedOld} menjadi Rp{$formattedNew}.",
            'product_id' => $this->product->id,
            'product_name' => $this->product->title,
            'old_price' => $this->oldPrice,
            'new_price' => $this->newPrice,
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
