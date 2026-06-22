<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class ProductReportResolvedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $report;

    /**
     * Create a new notification instance.
     */
    public function __construct(Report $report)
    {
        $this->report = $report;
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
        $product = $this->report->reportedProduct;
        $productName = $product ? $product->title : 'Produk Anda';
        $productId = $product ? $product->id : null;
        $statusTranslated = $this->report->status === 'Resolved' ? 'Diselesaikan' : ($this->report->status === 'Dismissed' ? 'Ditolak' : $this->report->status);

        return [
            'title' => 'Aduan Produk Diproses',
            'message' => "Laporan aduan terkait produk Anda \"{$productName}\" telah diselesaikan oleh Admin dengan status: {$statusTranslated}.",
            'report_id' => $this->report->id,
            'product_id' => $productId,
            'product_name' => $productName,
            'status' => $this->report->status,
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
