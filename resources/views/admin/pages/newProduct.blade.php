@extends('admin.layouts.app')

@section('title', 'New Product - Emart Admin')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">New Product</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Product List</a></li>
                <li class="breadcrumb-item active">New Product</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <div>
                        New Product
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.product.store-product') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label>Product Type</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="product_type" id="single-product"
                                        value="single" checked>
                                    <label class="form-check-label" for="single-product">
                                        Single Product
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="product_type" id="variant-product"
                                        value="variant">
                                    <label class="form-check-label" for="variant-product">
                                        Variable Product (with variants)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <label>Product Name</label>
                                <input type="text" name="product_name" class="form-control" placeholder="Product Name">
                                @error('product_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label>SKU</label>
                                <input type="text" name="sku" class="form-control" placeholder="SKU">
                                @error('sku')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Image</label>
                                <input type="file" name="image" class="form-control" placeholder="Image">
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Description</label>
                                <textarea name="description" class="form-control" cols="30" rows="5" placeholder="Description"></textarea>
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label>Category</label>
                                <select name="category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
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
                                        <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                    @endforeach
                                </select>
                                @error('brand_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- SINGLE PRODUCT SECTION -->
                            <div id="single-product-section" class="col-md-12">
                                <div class="row mt-4">
                                    <div class="col-md-4">
                                        <label>Original Price <span class="text-danger">*</span></label>
                                        <input type="number" name="original_price" class="form-control" id="original-price"
                                            placeholder="Enter original price" step="0.01" min="0">
                                        @error('original_price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label>Discount (%)</label>
                                        <input type="number" name="discount" class="form-control" id="discount"
                                            placeholder="Enter discount percentage" min="0" max="100" step="0.1">
                                        <small class="text-muted">Enter 0-100%</small>
                                        @error('discount')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label>Discounted Price <span id="discount-label" class="text-success"></span></label>
                                        <input type="number" name="discounted_price" class="form-control"
                                            id="discounted-price" placeholder="Auto-calculated or enter manually" step="0.01" min="0">
                                        <small class="text-muted">Will be calculated automatically</small>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label>Quantity in Stock <span class="text-danger">*</span></label>
                                        <input type="number" name="quantity_in_stock" class="form-control"
                                            placeholder="Enter quantity" min="0">
                                        @error('quantity_in_stock')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- VARIANT PRODUCT SECTION -->
                            <div id="variant-product-section" class="col-md-12" style="display: none;">
                                <div class="mt-4">
                                    <h4>Product Variants</h4>
                                    <hr>

                                    <button type="button" class="btn btn-success mb-3" id="add-variant">
                                        <i class="fas fa-plus"></i> Add Variant
                                    </button>

                                    <div id="variants-container"></div>
                                </div>
                            </div>

                            <div class="col-md-12 mt-4">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="{{ route('admin.product.products') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('js/admin-create-product.js') }}"></script>
@endsection
