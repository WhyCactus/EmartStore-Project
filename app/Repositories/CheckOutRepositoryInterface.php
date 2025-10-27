<?php

namespace App\Repositories;

interface CheckOutRepositoryInterface
{
    public function createOrder(array $data);
    public function createOrderItems($orderId, array $items);
    public function findOrderByCode($orderCode);
    public function createOrderShipping(array $data);
}
