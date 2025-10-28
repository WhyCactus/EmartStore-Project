<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateStatusRequest;
use App\Repositories\OrderRepository;

class AdminOrderController extends Controller
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function index()
    {
        $orders = $this->orderRepository->getAllOrders(10);
        return view("admin.pages.orderList", compact("orders"));
    }

    public function detail($id)
    {
        $order = $this->orderRepository->getOrderById($id);
        $availableStatuses = $this->orderRepository->getAvailableStatuses($order->order_status);
        return view("admin.pages.orderDetail", compact("order", "availableStatuses"));
    }

    public function updateStatus(UpdateStatusRequest $request, $id)
    {
        try {
            $request->validated();
            $this->orderRepository->updateStatus($id, $request->order_status);
            return redirect()->back()
                ->with('success', 'Order Status updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to update status'])
                ->withInput();
        }
    }
}
