<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class OrderRepository implements OrderRepositoryInterface
{
    protected $model;
    protected $auth;

    public function __construct(Order $model)
    {
        $this->model = $model;
        $this->auth = $auth ?? Auth::user();
    }

    public function getUserOrders(int $userId, int $perPage = 10): Paginator
    {
        $query = $this->model->where('user_id', $userId)->orderBy('created_at', 'desc');

        return $query->paginate($perPage);
    }

    public function getAuthUserOrders(int $perPage = 10): Paginator
    {
        return $this->getUserOrders($this->auth->id, $perPage);
    }

    public function getAllOrders(int $perPage = 10): Paginator
    {
        return $this->model->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function getOrderById(int $id): Order
    {
        return $this->model->with(['orderDetails','orderShipping'])->find($id);
    }
}
