<?php

namespace App\Repositories;

use App\Constants\OrderStatus;
use App\Constants\PaymentStatus;
use App\Mail\DeliverySuccessfulNotification;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Log;

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
        return $this->model->with(['orderDetails', 'orderShipping'])->find($id);
    }

    public function updateStatus(int $orderId, string $status): bool
    {
        $order = $this->model->find($orderId);

        if (!$order) {
            throw new \Exception("Order not found");
        }

        if (!$this->validateStatusTransition($order->order_status, $status)) {
            throw new \Exception("Invalid status transition from {$order->order_status} to {$status}");
        }

        if (OrderStatus::DELIVERED === $status) {
            try {
                Mail::to($order->user->email)
                    ->send(new DeliverySuccessfulNotification($order));
            } catch (\Throwable $e) {
                Log::error($e->getMessage());
            }
        }

        $updateData = $this->prepareStatusUpdateData($order, $status);

        $updated = $order->update($updateData);

        return $updated;
    }

    public function validateStatusTransition(string $currentStatus, string $newStatus): bool
    {
        $currentStatus = strtolower(trim($currentStatus));
        $newStatus = strtolower(trim($newStatus));

        $allowedTransitions = [
            'pending' => ['processing', 'cancelled'],
            'processing' => ['shipped', 'cancelled'],
            'shipped' => ['delivered'],
            'delivered' => [],
            'cancelled' => []
        ];

        if ($currentStatus === $newStatus) {
            return true;
        }

        return in_array($newStatus, $allowedTransitions[$currentStatus] ?? []);
    }

    public function getAvailableStatuses(string $currentStatus): array
    {
        $allowedTransitions = [
            'pending' => ['processing', 'cancelled'],
            'processing' => ['shipped', 'cancelled'],
            'shipped' => ['delivered'],
            'delivered' => [],
            'cancelled' => []
        ];

        return $allowedTransitions[$currentStatus] ?? [];
    }

    public function prepareStatusUpdateData($order, string $status)
    {
        $data = ['order_status' => $status];

        if ($status === OrderStatus::CANCELLED) {
            $data['cancelled_at'] = Carbon::now();
        }

        if ($status === OrderStatus::DELIVERED) {
            $data['payment_status'] = PaymentStatus::PAID;
        }

        return $data;
    }

    public function cancelOrderbyId(int $id): void
    {
        $order = Order::find($id);
        $order->order_status = OrderStatus::CANCELLED;
        $order->cancelled_at = Carbon::now();
        $order->save();
    }

    public function getTotalOrdersCount()
    {
        return $this->model
            ->where('order_status', '!=', OrderStatus::CANCELLED)
            ->count();
    }

    public function getTotalRevenue()
    {
        return $this->model
            ->where('payment_status', PaymentStatus::PAID)
            ->sum('total_amount');
    }
}
