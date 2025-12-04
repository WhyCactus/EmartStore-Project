<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Notifications\OrderNotification;
use App\Repositories\StripePaymentRepositoryInterface;
use App\Services\CheckOutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class StripePaymentController extends Controller
{
    protected $stripePaymentRepository;
    protected $checkOutService;

    public function __construct(StripePaymentRepositoryInterface $stripePaymentRepository, CheckOutService $checkOutService)
    {
        $this->stripePaymentRepository = $stripePaymentRepository;
        $this->checkOutService = $checkOutService;
    }

    public function showStripe()
    {
        $pendingOrderId = Session::get('pending_order_id');
        $checkoutData = Session::get('checkout_data');

        if (!$pendingOrderId || !$checkoutData) {
            return redirect()->route('cart.list')->with('error', 'No pending order found.');
        }

        $order = Order::with(['orderDetails', 'orderShipping'])->find($pendingOrderId);

        return view('client.pages.stripe', compact('order', 'checkoutData'));
    }

    public function processPayment(Request $request)
    {
        try {
            $pendingOrderId = Session::get('pending_order_id');
            if (!$pendingOrderId) {
                return redirect()->route('cart.list')->with('error', 'No pending order found.');
            }

            $charge = $this->stripePaymentRepository->createCharge([
                'amount' => $request->input('amount') * 100,
                'currency' => 'usd',
                'source' => $request->input('stripeToken'),
                'description' => 'Order Payment',
                'metadata' => [
                    'order_id' => $pendingOrderId,
                    'order_code' => $request->order_code,
                ],
            ]);

            $order = $this->checkOutService->completeStripePayment($pendingOrderId);

            $user = Auth::user();
            $user->notify(new OrderNotification(
                $order,
                $order->order_code,
                'Your order has been placed successfully!',
                'order'
            ));

            return redirect()
                ->route('checkout.success', ['orderCode' => $order->order_code])
                ->with('success', 'Order processed successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }
}
