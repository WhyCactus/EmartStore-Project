<?php

namespace App\Repositories;

interface DashboardRepositoryInterface
{
    public function getTotalUsersCount(): int;

    public function getTotalOrdersCount(): int;

    public function getTotalProductsCount(): int;

    public function getTotalRevenue(): float;
}
