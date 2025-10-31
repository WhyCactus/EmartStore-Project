<?php

namespace App\Http\Controllers;

use App\Services\HomeService;
use App\Services\CategoryService;
use App\Services\BrandService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $homeService;
    protected $categoryService;
    protected $brandService;

    public function __construct(HomeService $homeService, CategoryService $categoryService, BrandService $brandService)
    {
        $this->homeService = $homeService;
        $this->categoryService = $categoryService;
        $this->brandService = $brandService;
    }

    public function index()
    {
        try {
            $categories = $this->homeService->getCategories();
            $featuredProducts = $this->homeService->getFeaturedProducts();
            $recentProducts = $this->homeService->getRecentProducts();
            return view('home.index', compact('featuredProducts', 'recentProducts', 'categories'));
        } catch (\Throwable $e) {
            return abort(404);
        }
    }

    public function list(Request $request)
    {
        try {
            $sort = $request->get('sort', 'newest');
            $products = $this->homeService->getAllProducts($sort);
            $categories = $this->categoryService->getAllCategories();
            $brands = $this->brandService->getAllBrands();
            return view('pages.product-list', compact('products', 'categories', 'brands', 'sort'));
        } catch (\Throwable $e) {
            return redirect()
                ->route('home')
                ->with('error', 'Error loading products: ' . $e->getMessage());
        }
    }

    public function getProductByCategory(Request $request, $categoryId)
    {
        try {
            $sort = $request->get('sort', 'newest');
            $products = $this->homeService->getProductsByCategory($categoryId, $sort);
            $categories = $this->categoryService->getAllCategories();
            $brands = $this->brandService->getAllBrands();
            return view('pages.product-list', compact('products', 'categories', 'brands', 'sort'));
        } catch (\Throwable $e) {
            return redirect()
                ->route('home')
                ->with('error', 'Error loading products: ' . $e->getMessage());
        }
    }

    public function getProductByBrand(Request $request, $brandId)
    {
        try {
            $sort = $request->get('sort', 'newest');
            $products = $this->homeService->getProductsByBrand($brandId, $sort);
            $categories = $this->categoryService->getAllCategories();
            $brands = $this->brandService->getAllBrands();
            return view('pages.product-list', compact('products', 'categories', 'brands', 'sort'));
        } catch (\Throwable $e) {
            return redirect()
                ->route('home')
                ->with('error', 'Error loading products: ' . $e->getMessage());
        }
    }
}
