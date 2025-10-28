<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Contracts\Pagination\Paginator;

interface OrderRepositoryInterface
{
    public function getUserOrders(int $userId, int $perPage = 10): Paginator;
    public function getAuthUserOrders(int $perPage = 10): Paginator;
    public function getAllOrders(int $perPage = 10): Paginator;
    public function getOrderById(int $id): Order;
    public function updateStatus(int $id, string $status);
    public function validateStatusTransition(string $currentStatus, string $newStatus);
}
