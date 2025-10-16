<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Services\ProductService;
use App\Http\Requests\ProductRequest;

class AdminProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getAllProductsWithRelations(['brand', 'category']);

        $categories = Category::withCount('products')->get();
        $brands = Brand::withCount('products')->get();

        return view('admin.pages.productList', compact('products', 'categories', 'brands'));
    }

    public function create()
    {
        $products = $this->productService->getAllProductsWithRelations(['brand', 'category']);

        $categories = Category::withCount('products')->get();
        $brands = Brand::withCount('products')->get();

        return view('admin.pages.newProduct', compact('categories', 'brands', 'products'));
    }

    public function store(ProductRequest $request)
    {
        try {
            $this->productService->createProduct($request->all());
            return redirect()->route('admin.products')->with('success', 'Add product successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error creating product: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $product = $this->productService->getProductByIdWithRelations($id, ['brand', 'category']);
        $categories = Category::withCount('products')->get();
        $brands = Brand::withCount('products')->get();

        return view('admin.pages.editProduct', compact('product', 'categories', 'brands'));
    }

    public function update(ProductRequest $request, $id)
    {
        try {
            $data = $request->only(['product_name', 'product_code', 'original_price', 'discounted_price', 'quantity_in_stock', 'description', 'category_id', 'brand_id']);

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $data['image'] = $request->file('image');
            }

            $this->productService->updateProduct($id, $data);
            return redirect()->route('admin.products')->with('success', 'Update product successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error updating product: ' . $e->getMessage());
        }
    }
}
