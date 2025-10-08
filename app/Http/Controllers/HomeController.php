<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')
            ->get();

        $featuredProducts = Product::with('brand', 'category')
            ->where('status', 'active')
            ->where('quantity_in_stock', '>', 0)
            ->inRandomOrder()
            ->limit(5)
            ->get();

        $recentProducts = Product::with('brand', 'category')
            ->where('status', 'active')
            ->where('quantity_in_stock', '>', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('home.index', compact('featuredProducts', 'recentProducts','categories'));
    }

    public function list(Request $request)
    {
        $sort = $request->get('sort', 'newest');

        $categories = Category::withCount('products')->get();
        $brands = Brand::withCount('products')->get();

        $products = Product::with('brand', 'category')
            ->when($sort === 'newest', function ($query) {
                return $query->orderBy('created_at', 'desc');
            })
            ->when($sort === 'popular', function ($query) {
                return $query->orderBy('sold_count', 'desc');
            })
            ->where('status', 'active')
            ->where('quantity_in_stock', '>', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('pages.product-list', compact('products', 'categories', 'brands', 'sort'));
    }

    public function getProductByCategory(Request $request, $categoryId)
    {
        $sort = $request->get('sort', 'newest');

        $categories = Category::withCount('products')->get();
        $brands = Brand::withCount('products')->get();

        $products = Product::where('category_id', $categoryId)
            ->when($sort === 'newest', function ($query) {
                return $query->orderBy('created_at', 'desc');
            })
            ->when($sort === 'popular', function ($query) {
                return $query->orderBy('sold_count', 'desc');
            })
            ->where('status', 'active')
            ->paginate(9);

        return view('pages.product-list', compact('products', 'categories', 'brands', 'sort'));
    }

    public function getProductByBrand(Request $request, $brandId)
    {
        $sort = $request->get('sort', 'newest');

        $categories = Category::withCount('products')->get();
        $brands = Brand::withCount('products')->get();

        $products = Product::where('brand_id', $brandId)
            ->when($sort === 'newest', function ($query) {
                return $query->orderBy('created_at', 'desc');
            })
            ->when($sort === 'popular', function ($query) {
                return $query->orderBy('sold_count', 'desc');
            })
            ->where('status', 'active')
            ->paginate(9);

        return view('pages.product-list', compact('products', 'categories', 'brands', 'sort'));
    }
}
