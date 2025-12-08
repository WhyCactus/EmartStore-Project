<?php

namespace App\Console\Commands;

use App\Constants\OrderStatus;
use App\Constants\PaymentStatus;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class SendStripePaymentWarnings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:send-stripe-payment-warnings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send warnings for expired Stripe payments';

    /**\
     *
     * \
     * Execute the console command.
     */
    public function handle()
    {
        $warningOrders = Order::where('payment_method', 'stripe')
            ->where('payment_status', PaymentStatus::PENDING)
            ->where('order_status', OrderStatus::PENDING)
            ->whereBetween('created_at', [
                Carbon::now()->subMinutes(15),
                Carbon::now()->subMinutes(11),
            ])
            ->get();

        if ($warningOrders->isEmpty()) {
            $this->info('No orders requiring payment warnings.');
            return 0;
        }

        $sentCount = 0;

        foreach ($warningOrders as $order) {
            $cacheKey = "payment_warning_sent_{$order->id}";

            if (Cache::has($cacheKey)) {
                $this->info("Warning already sent for order: {$order->order_code}");
                continue;
            }

            try {
                $minutesElapsed = $order->created_at->diffInMinutes(now());
                $minutesRemaining = 20 - $minutesElapsed;

                if ($minutesRemaining > 0 && $minutesRemaining <= 10) {
                    Mail::to($order->user->email)
                        ->send(new \App\Mail\SendStripePaymentWarnings($order, $minutesRemaining));

                    Cache::put($cacheKey, true, now()->addMinutes(30));

                    $sentCount++;
                    $this->info("Sent warning for order: {$order->order_code} ({$minutesRemaining} mins remaining)");
                }
            } catch (\Exception $e) {
                $this->error("Failed to send warning for order {$order->order_code}: {$e->getMessage()}");
            }
        }

        $this->info("Total warnings sent: {$warningOrders->count()}");
        return 0;
    }
}
