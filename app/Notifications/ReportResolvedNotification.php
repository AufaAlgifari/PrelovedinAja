<?php

namespace App\Notifications;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class ReportResolvedNotification extends Notification implements ShouldQueue
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
        $statusTranslated = $this->report->status === 'Resolved' ? 'Diselesaikan' : ($this->report->status === 'Dismissed' ? 'Ditolak' : $this->report->status);
        return [
            'title' => 'Laporan Diproses',
            'message' => "Laporan Anda dengan ID #{$this->report->id} (Kategori: {$this->report->category}) telah berstatus: {$statusTranslated}.",
            'report_id' => $this->report->id,
            'status' => $this->report->status,
            'category' => $this->report->category,
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
