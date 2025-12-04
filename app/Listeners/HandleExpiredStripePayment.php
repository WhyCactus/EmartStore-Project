<?php

namespace App\Listeners;

use App\Constants\OrderStatus;
use App\Constants\PaymentStatus;
use App\Mail\SendExpiredStripePayment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class HandleExpiredStripePayment implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $order = $event->order;

        try {
            DB::transaction(function () use ($order) {
                $order->update([
                    'order_status' => OrderStatus::CANCELLED,
                    'payment_status' => PaymentStatus::CANCELLED,
                    'cancelled_at' => now(),
                    'cancelled_reason' => 'Payment window expired for Stripe payment.',
                ]);

                foreach ($order->orderDetails as $orderDetail) {
                    if ($orderDetail->product_variant_id) {
                        $variant = $orderDetail->productVariant;
                        if ($variant) {
                            $variant->increment('stock', $orderDetail->quantity);
                        } else {
                            $product = $orderDetail->product;
                            if ($product) {
                                $product->increment('stock', $orderDetail->quantity);
                            }
                        }
                    }
                }

                try {
                    Mail::to($order->user->email)
                        ->send(new SendExpiredStripePayment($order));
                } catch (\Exception $e) {
                    Log::error("Failed to send payment expired email: " . $e->getMessage());
                }
            });
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
