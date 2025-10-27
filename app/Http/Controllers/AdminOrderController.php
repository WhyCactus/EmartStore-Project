<?php

namespace App\Http\Controllers;

use App\Repositories\OrderRepositoryInterface;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
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
        
        return view("admin.pages.orderDetail", compact("order"));
    }
}
