<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Notifications\InactiveListingReminderNotification;
use Illuminate\Console\Command;

class SendInactiveListingReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-inactive-listing-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find products untouched for > 14 days and notify their sellers.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cutoff = now()->subDays(14);

        $products = Product::where('status', 'Available')
            ->where('updated_at', '<', $cutoff)
            ->with('seller')
            ->get();

        $count = 0;
        foreach ($products as $product) {
            if ($product->seller) {
                $product->seller->notify(new InactiveListingReminderNotification($product));
                $count++;
            }
        }

        $this->info("Successfully sent {$count} inactive listing reminder notifications.");
    }
}
