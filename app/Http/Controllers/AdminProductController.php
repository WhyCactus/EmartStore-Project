<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditProductRequest;
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
            return redirect()->route('admin.product.products')->with('success', 'Add product successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error creating product: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $product = $this->productService->getProductByIdWithRelations($id, ['brand', 'category', 'productVariants', 'productVariants.attributes', 'productVariants.attributes.attribute']);
            $categories = Category::withCount('products')->get();
            $brands = Brand::withCount('products')->get();
            return view('admin.pages.editProduct', compact('product', 'categories', 'brands'));
        } catch (\Exception $e) {
            abort(404, $e->getMessage());
        }
    }

    public function update(EditProductRequest $request, $id)
    {
        try {
            $data = $this->prepareProductData($request);

            $this->productService->updateProduct($id, $data);

            return redirect()
                ->route('admin.product.products')
                ->with('success', 'Update product successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error updating product: ' . $e->getMessage());
        }
    }

    private function prepareProductData($request)
    {
        $data = $request->only([
            'product_name',
            'sku',
            'original_price',
            'discounted_price',
            'quantity_in_stock',
            'description',
            'category_id',
            'brand_id',
            'product_type'
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $data['image'] = $request->file('image');
        }

        if ($request->has('variants') && is_array($request->variants)) {
            $data['variants'] = $this->prepareVariantsData($request);
        }

        return $data;
    }

    private function prepareVariantsData($request)
    {
        $variants = [];

        foreach ($request->variants as $index => $variant) {
            $variantData = [
                'id' => $variant['id'] ?? null,
                'sku' => $variant['sku'],
                'price' => $variant['price'],
                'quantity_in_stock' => $variant['quantity_in_stock'],
            ];

            if ($request->hasFile("variants.{$index}.image")) {
                $variantImage = $request->file("variants.{$index}.image");
                if ($variantImage->isValid()) {
                    $variantData['image'] = $variantImage;
                }
            }

            if (isset($variant['attributes']) && is_array($variant['attributes'])) {
                $variantData['attributes'] = $variant['attributes'];
            }

            $variants[] = $variantData;
        }

        return $variants;
    }

    public function destroy($id)
    {
        try {
            $this->productService->deleteProduct($id);
            return redirect()->route('admin.product.products')->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error deleting product: ' . $e->getMessage());
        }
    }
}
