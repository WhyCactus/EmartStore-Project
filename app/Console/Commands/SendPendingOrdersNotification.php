<?php

namespace App\Console\Commands;

use App\Mail\PendingOrdersNotification;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Mail;

class SendPendingOrdersNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:send-pending-orders-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email notification for peding orders to admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pendingOrders = Order::where('order_status', 'pending')
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->with(['user', 'orderDetails.product'])
            ->get();

        if ($pendingOrders->isEmpty()) {
            $this->info('No pending orders found in the last 24 hours.');
            return 0;
        }

        $totalPending = $pendingOrders->count();
        $totalRevenue = $pendingOrders->sum('total_amount');

        $adminEmail = config('app.admin_email');

        try {
            Mail::to($adminEmail)->send(new PendingOrdersNotification(
                $pendingOrders,
                $totalPending,
                $totalRevenue
            ));

            $this->info("Successfully send Email. Order: {$totalPending}, Revenue {$totalRevenue}");
        } catch (\Throwable $e) {
            $this->error('Failed to send Email'. $e->getMessage());
            return 1;
        }

        return 0;
    }
}
