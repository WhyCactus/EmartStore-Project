<?php

namespace App\Http\Controllers;

use App\Repositories\DashboardRepository;

class DashboardController extends Controller
{
    protected $dashboardRepository;

    public function __construct(DashboardRepository $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    public function index()
    {
        try {
            $stats = [
                'totalUsers' => $this->dashboardRepository->getTotalUsersCount(),
                'totalOrders' => $this->dashboardRepository->getTotalOrdersCount(),
                'totalProducts' => $this->dashboardRepository->getTotalProductsCount(),
                'totalRevenue' => $this->dashboardRepository->getTotalRevenue(),
            ];

            $totalUsers = $stats['totalUsers'];
            $totalOrders = $stats['totalOrders'];
            $totalProducts = $stats['totalProducts'];
            $totalRevenue = $stats['totalRevenue'];

            $orders = $this->dashboardRepository->getAllOrders();

            return view('admin.pages.dashboard', compact('totalUsers', 'orders', 'totalOrders', 'totalProducts', 'totalRevenue'));
        } catch (\Throwable $e) {
            return abort(404);
        }
    }
}
