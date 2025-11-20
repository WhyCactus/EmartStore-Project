<?php

namespace App\Repositories;

class DashboardRepository implements DashboardRepositoryInterface
{
    protected $userRepository;
    protected $orderRepository;
    protected $productRepository;

    public function __construct(
        UserRepository $userRepository,
        OrderRepositoryInterface $orderRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->userRepository = $userRepository;
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
    }

    public function getTotalUsersCount(): int
    {
        return $this->userRepository->getTotalUsersCount();
    }

    public function getTotalOrdersCount(): int
    {
        return $this->orderRepository->getTotalOrdersCount();
    }

    public function getTotalProductsCount(): int
    {
        return $this->productRepository->getTotalProductsCount();
    }

    public function getTotalRevenue(): float
    {
        return $this->orderRepository->getTotalRevenue();
    }

    public function getAllOrders()
    {
        return $this->orderRepository->getAllOrders();
    }
}
