<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with(['brand', 'category'])
            ->findOrFail($id);

        $categories = Category::withCount('products')->get();
        $brands = Brand::withCount('products')->get();

        $relatedProducts = Product::with('brand', 'category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->where('quantity_in_stock', '>', 0)
            ->get();

        return view('pages.product-detail', compact('product', 'categories', 'brands', 'relatedProducts'));
    }


}
