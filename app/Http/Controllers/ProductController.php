<?php

namespace App\Http\Controllers;

use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;
    protected $categoryService;
    protected $brandService;

    public function __construct(ProductService $productService, CategoryService $categoryService, BrandService $brandService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->brandService = $brandService;
    }

    public function show($id)
    {
        try {
            $product = $this->productService->getProductByIdWithRelations($id, ['brand', 'category']);
            $relatedProducts = $this->productService->getRelatedProducts($product->id);
            return view('pages.product-detail', compact('product', 'relatedProducts'));
        } catch (\Throwable $e) {
            return redirect()->route('home')->with('error', $e->getMessage());
        }
    }
}
