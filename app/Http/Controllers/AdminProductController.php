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
            ->orderBy('id', 'desc')
            ->get();

        $categories = Category::withCount('products')->get();
        $brands = Brand::withCount('products')->get();

        return view('admin.pages.productList', compact('products', 'categories', 'brands'));
    }

    public function create()
    {
        $categories = Category::withCount('products')->get();
        $brands = Brand::withCount('products')->get();

        return view('admin.pages.newProduct', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'product_code' => 'required|unique:products,product_code',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'original_price' => 'required',
            'discounted_price' => 'nullable',
            'quantity_in_stock' => 'required',
            'description' => 'nullable',
            'category_id' => 'required',
            'brand_id' => 'required',
        ],[
            'product_name.required' => 'Product name is required',
            'product_code.required' => 'Product code is required',
            'product_code.unique' => 'Product code already exists',
            'image.image' => 'Image must be an image file',
            'image.mimes' => 'Image must be a JPEG, PNG, JPG, or GIF file',
            'image.max' => 'Image size must not exceed 2MB',
            'original_price.required' => 'Original price is required',
            'quantity_in_stock.required' => 'Quantity in stock is required',
            'category_id.required' => 'Category is required',
            'brand_id.required' => 'Brand is required',
        ]);

        $data=[
            'product_name' => $request->product_name,
            'product_code' => $request->product_code,
            'original_price' => $request->original_price,
            'discounted_price' => $request->discounted_price,
            'quantity_in_stock' => $request->quantity_in_stock,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'status' => 'active',
            'sold_count' => 0
        ];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }

        Product::create($data);

        return redirect()->route('admin.products')->with('success', 'Add product successfully!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::withCount('products')->get();
        $brands = Brand::withCount('products')->get();

        return view('admin.pages.editProduct', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'required',
            'product_code' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'original_price' => 'required',
            'discounted_price' => 'nullable',
            'quantity_in_stock' => 'required',
            'description' => 'nullable',
            'category_id' => 'required',
            'brand_id' => 'required',
        ],[
            'product_name.required' => 'Product name is required',
            'product_code.required' => 'Product code is required',
            'image.image' => 'Image must be an image file',
            'image.mimes' => 'Image must be a JPEG, PNG, JPG, or GIF file',
            'image.max' => 'Image size must not exceed 2MB',
            'original_price.required' => 'Original price is required',
            'quantity_in_stock.required' => 'Quantity in stock is required',
            'category_id.required' => 'Category is required',
            'brand_id.required' => 'Brand is required',
        ]);

        $data=[
            'product_name' => $request->product_name,
            'product_code' => $request->product_code,
            'original_price' => $request->original_price,
            'discounted_price' => $request->discounted_price,
            'quantity_in_stock' => $request->quantity_in_stock,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'status' => 'active',
            'sold_count' => 0
        ];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }

        Product::where('id', $id)->update($data);

        return redirect()->route('admin.products')->with('success', 'Update product successfully!');
    }
}
