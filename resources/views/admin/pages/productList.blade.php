@extends('admin.layouts.app')

@section('title', 'Product List - Emart Admin')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Products</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Products</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-table me-1"></i>
                        Products
                    </div>
                    <a href="{{ route('admin.product.create-product') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i>
                        New Product
                    </a>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product Code</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Brands</th>
                                <th>Quantity</th>
                                <th>Sold Count</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->sku }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="" width="50px"
                                            height="50px">
                                    </td>
                                    <td>
                                        @if ($product->discounted_price && $product->discounted_price < $product->original_price)
                                            <span
                                                class="text-decoration-line-through">${{ number_format($product->original_price, 2) }}</span><br>
                                            ${{ number_format($product->discounted_price, 2) }}
                                        @else
                                            ${{ number_format($product->original_price, 2) }}
                                        @endif
                                    </td>
                                    <td>{{ $product->category->category_name }}</td>
                                    <td>{{ $product->brand->brand_name }}</td>
                                    <td>{{ $product->quantity_in_stock }}</td>
                                    <td>{{ $product->sold_count }}</td>
                                    <td>{{ $product->status }}</td>
                                    <td>
                                        <a href="#" class="btn btn-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.product.edit-product', $product->id) }}"
                                            class="btn btn-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.product.delete-product', $product->id) }}"
                                            method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this product?');">
                                                <i class="bi bi-dash-circle"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
