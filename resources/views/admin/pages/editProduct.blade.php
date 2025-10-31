@extends('admin.layouts.app')

@section('title', 'Edit Product - Emart Admin')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Edit Product</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Product List</a></li>
                <li class="breadcrumb-item active">Edit Product</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <div>
                        Edit Product
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.product.update-product', $product->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <label>Product Name</label>
                                <input type="text" name="product_name" class="form-control"
                                    value="{{ old('product_name', $product->product_name) }}">
                                @error('product_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label>Product Code</label>
                                <input type="text" name="product_code" class="form-control"
                                    value="{{ old('product_code', $product->product_code) }}">
                                @error('product_code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Image</label>
                                <div>
                                    @if (isset($product->image) && $product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="Image"
                                            style="max-width: 100px; max-height: 100px;">
                                    @endif
                                </div>
                                <input type="file" name="image" class="form-control" placeholder="Image">
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Description</label>
                                <textarea name="description" class="form-control" cols="30" rows="5">{{ old('description', $product->description) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label>Category</label>
                                <select name="category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label>Brand</label>
                                <select name="brand_id" class="form-control">
                                    <option value="">Select Brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->brand_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('brand_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label>Price</label>
                                <input type="number" name="original_price" class="form-control" id="original-price"
                                    value="{{ old('original_price', $product->original_price) }}">
                                @error('original_price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label>Discount (%)</label>
                                <input type="number" name="discount" class="form-control" id="discount"
                                    placeholder="Discount" min="0" max="100" step="0.1">
                            </div>
                            <div class="col-md-4">
                                <label>Discounted Price</label>
                                <input type="number" name="discounted_price" class="form-control" id="discounted-price"
                                    value="{{ old('discounted_price', $product->discounted_price) }}">
                            </div>
                            <div class="col-md-12">
                                <label>Quantity</label>
                                <input type="number" name="quantity_in_stock" class="form-control"
                                    value="{{ old('quantity_in_stock', $product->quantity_in_stock) }}">
                                @error('quantity_in_stock')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mt-3">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
