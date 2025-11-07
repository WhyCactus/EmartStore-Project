<?php

namespace App\Http\Controllers;

use App\Repositories\OrderRepositoryInterface;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function orderList()
    {
        try {
            $orders = $this->orderRepository->getAuthUserOrders(10);
            return view('client.pages.my-account', compact('orders'));
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function detail($id)
    {
        try {
            $order = $this->orderRepository->getOrderById($id);
            return view('client.pages.order-detail', compact('order'));
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Order Not Found');
        }
    }

    public function cancelOrder($id)
    {
        try {
            $this->orderRepository->cancelOrderbyId($id);
            return redirect()->back()->with('success','Order cancelled success');
        } catch (\Throwable $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', 'Server Error');
        }
    }
}
