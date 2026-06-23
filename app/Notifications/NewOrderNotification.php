<?php

namespace App\Notifications;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    protected $transaction;

    /**
     * Create a new notification instance.
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
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
        $buyerName = $this->transaction->user ? $this->transaction->user->name : 'Pembeli';
        $productTitle = $this->transaction->product ? $this->transaction->product->title : 'Produk';
        $amount = $this->transaction->amount;

        return [
            'type'         => 'new_order',
            'title'        => 'Pesanan Masuk',
            'message'      => "{$buyerName} memesan \"{$productTitle}\" senilai Rp " . number_format($amount, 0, ',', '.'),
            'buyer_id'     => $this->transaction->buyer_id,
            'buyer_name'   => $buyerName,
            'product_id'   => $this->transaction->product_id,
            'product_title' => $productTitle,
            'transaction_id' => $this->transaction->id,
            'amount'       => $amount,
            'url'          => '/seller/dashboard',
        ];
    }
}
