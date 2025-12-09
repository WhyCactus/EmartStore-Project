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
                        enctype="multipart/form-data" id="edit-product-form">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="product_type" id="product_type"
                            value="{{ old('product_type', count($product->productVariants ?? []) > 0 ? 'variant' : 'single') }}">

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
                                <label>SKU</label>
                                <input type="text" name="sku" class="form-control"
                                    value="{{ old('sku', $product->sku) }}">
                                @error('sku')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Image</label>
                                <div>
                                    @if (isset($product->image) && $product->image)
                                        <img src="{{ minioUrl($product->image) }}" alt="Image"
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
                                @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
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
                        </div>

                        <!-- Single Product Section -->
                        <div class="row">
                            <div id="single-product-section" class="col-md-12 mt-3">
                                <h5 class="mb-3">Product Pricing & Stock</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Price</label>
                                        <input type="number" name="original_price" class="form-control" id="original-price"
                                            step="0.01" value="{{ old('original_price', $product->original_price) }}">
                                        @error('price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label>Discounted Price</label>
                                        <input type="number" name="discounted_price" class="form-control"
                                            id="discounted-price" step="0.01"
                                            value="{{ old('discounted_price', $product->discounted_price) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Quantity in Stock</label>
                                        <input type="number" name="quantity_in_stock" class="form-control"
                                            value="{{ old('quantity_in_stock', $product->quantity_in_stock) }}">
                                        @error('quantity_in_stock')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Product Variants Section -->
                        <div class="row">
                            <div id="variants-section" class="col-md-12 mt-4">
                                <h5 class="mb-3">Product Variants</h5>
                                <div id="variants-container">
                                    @forelse($product->productVariants ?? [] as $variant)
                                        <div class="variant-item border p-3 mb-3">
                                            <!-- Hidden Variant ID -->
                                            <input type="hidden" name="variants[{{ $loop->index }}][id]"
                                                value="{{ $variant->id }}">

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label>SKU</label>
                                                    <input type="text" name="variants[{{ $loop->index }}][sku]"
                                                        class="form-control"
                                                        value="{{ old('variants.' . $loop->index . '.sku', $variant->sku) }}">
                                                    @error('variants.' . $loop->index . '.sku')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Price</label>
                                                    <input type="number" name="variants[{{ $loop->index }}][price]"
                                                        class="form-control" step="0.01"
                                                        value="{{ old('variants.' . $loop->index . '.price', $variant->price) }}">
                                                    @error('variants.' . $loop->index . '.price')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Quantity in Stock</label>
                                                    <input type="number"
                                                        name="variants[{{ $loop->index }}][quantity_in_stock]"
                                                        class="form-control"
                                                        value="{{ old('variants.' . $loop->index . '.quantity_in_stock', $variant->quantity_in_stock) }}">
                                                    @error('variants.' . $loop->index . '.quantity_in_stock')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Image</label>
                                                    @if (isset($variant->image) && $variant->image)
                                                        <div>
                                                            <img src="{{ minioUrl($variant->image) }}"
                                                                alt="Variant Image"
                                                                style="max-width: 50px; max-height: 50px;">
                                                        </div>
                                                    @endif
                                                    <input type="file" name="variants[{{ $loop->index }}][image]"
                                                        class="form-control">
                                                    @error('variants.' . $loop->index . '.image')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Attributes Section -->
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <label><strong>Attributes</strong></label>
                                                    <div class="attributes-container">
                                                        @forelse($variant->attributes ?? [] as $attr)
                                                            <div class="row mb-2">
                                                                <div class="col-md-5">
                                                                    <input type="text"
                                                                        name="variants[{{ $loop->parent->index }}][attributes][{{ $loop->index }}][name]"
                                                                        class="form-control"
                                                                        placeholder="Attribute Name (e.g., Color, Size)"
                                                                        value="{{ old('variants.' . $loop->parent->index . '.attributes.' . $loop->index . '.name', $attr->attribute->name ?? '') }}">
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <input type="text"
                                                                        name="variants[{{ $loop->parent->index }}][attributes][{{ $loop->index }}][value]"
                                                                        class="form-control"
                                                                        placeholder="Attribute Value (e.g., Red, XL)"
                                                                        value="{{ old('variants.' . $loop->parent->index . '.attributes.' . $loop->index . '.value', $attr->value ?? '') }}">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <button type="button"
                                                                        class="btn btn-danger btn-sm remove-attribute">Remove</button>
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <div class="row mb-2">
                                                                <div class="col-md-5">
                                                                    <input type="text"
                                                                        name="variants[{{ $loop->index }}][attributes][0][name]"
                                                                        class="form-control"
                                                                        placeholder="Attribute Name (e.g., Color, Size)">
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <input type="text"
                                                                        name="variants[{{ $loop->index }}][attributes][0][value]"
                                                                        class="form-control"
                                                                        placeholder="Attribute Value (e.g., Red, XL)">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <button type="button"
                                                                        class="btn btn-danger btn-sm remove-attribute">Remove</button>
                                                                </div>
                                                            </div>
                                                        @endforelse
                                                    </div>
                                                    <button type="button" class="btn btn-secondary btn-sm add-attribute"
                                                        data-variant-index="{{ $loop->index }}">
                                                        <i class="fas fa-plus"></i> Add Attribute
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="mt-2">
                                                <button type="button" class="btn btn-danger btn-sm remove-variant">
                                                    <i class="fas fa-trash"></i> Remove Variant
                                                </button>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="variant-item border p-3 mb-3">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label>SKU</label>
                                                    <input type="text" name="variants[0][sku]" class="form-control"
                                                        placeholder="SKU">
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Price</label>
                                                    <input type="number" name="variants[0][price]" class="form-control"
                                                        step="0.01" placeholder="Price">
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Quantity in Stock</label>
                                                    <input type="number" name="variants[0][quantity_in_stock]"
                                                        class="form-control" placeholder="Stock">
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Image</label>
                                                    <input type="file" name="variants[0][image]" class="form-control">
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <label><strong>Attributes</strong></label>
                                                    <div class="attributes-container">
                                                        <div class="row mb-2">
                                                            <div class="col-md-5">
                                                                <input type="text"
                                                                    name="variants[0][attributes][0][name]"
                                                                    class="form-control"
                                                                    placeholder="Attribute Name (e.g., Color, Size)">
                                                            </div>
                                                            <div class="col-md-5">
                                                                <input type="text"
                                                                    name="variants[0][attributes][0][value]"
                                                                    class="form-control"
                                                                    placeholder="Attribute Value (e.g., Red, XL)">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm remove-attribute">Remove</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-secondary btn-sm add-attribute"
                                                        data-variant-index="0">
                                                        <i class="fas fa-plus"></i> Add Attribute
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="mt-2">
                                                <button type="button" class="btn btn-danger btn-sm remove-variant">
                                                    <i class="fas fa-trash"></i> Remove Variant
                                                </button>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                                <button type="button" class="btn btn-success btn-sm" id="add-variant">
                                    <i class="fas fa-plus"></i> Add Variant
                                </button>
                            </div>
                        </div>

                        <!-- Submit Button - LUÔN HIỂN THỊ -->
                        <div class="row">
                            <div class="col-md-12 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save
                                </button>
                                <a href="{{ route('admin.product.products') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        let variantCount = {{ count($product->productVariants ?? []) }};
        let attributeCount = {};
        const hasVariants = {{ count($product->productVariants ?? []) > 0 ? 'true' : 'false' }};
    </script>
    <script src="{{ asset('js/admin-edit-product.js') }}"></script>
@endsection
