<?php

namespace App\Http\Controllers;

use App\Constants\PaymentMethod;
use App\Events\OrderCreated;
use App\Http\Requests\CheckOutRequest;
use App\Models\Order;
use App\Notifications\OrderNotification;
use App\Services\CheckOutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckOutController extends Controller
{
    public function __construct(private CheckOutService $checkOutService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function showCheckOut()
    {
        try {
            $checkOutData = $this->checkOutService->getCheckOutData(Auth::user()->id);

            if ($checkOutData['totalItems'] === 0) {
                return redirect()->route('cart.list')->with('error', 'Your cart is empty!');
            }
            return view('client.pages.checkout', $checkOutData);
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function processCheckOut(CheckOutRequest $request)
    {
        try {
            $order = $this->checkOutService->processCheckOut(Auth::user()->id, $request->validated());

            if ($request->payment_method === PaymentMethod::STRIPE) {
                return redirect()->route('stripe')->withInput(['order_id' => $order->id]);
            }

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
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function checkoutSuccess($orderCode)
    {
        session()->forget('cart_count');

        $order = Order::with(['orderDetails', 'orderShipping'])
            ->where('order_code', $orderCode)
            ->firstOrFail();

        return view('client.pages.checkout-success', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
