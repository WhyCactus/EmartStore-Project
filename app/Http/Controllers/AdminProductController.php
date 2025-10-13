<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::with('brand', 'category')
            ->orderBy('created_at', 'desc')
            ->get();

        $categories = Category::withCount('products')->get();
        $brands = Brand::withCount('products')->get();

        return view('admin.pages.productList', compact('products', 'categories', 'brands'));
    }


}
