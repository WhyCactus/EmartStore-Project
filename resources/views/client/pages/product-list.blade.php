@extends('client.layouts.app')

@section('title', 'Product List - E Shop')

@section('content')
    <!-- Product List Start -->
    <div class="product-view">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="product-short">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                @switch($sort)
                                                    @case('newest')
                                                        Newest
                                                    @break

                                                    @case('popular')
                                                        Popular
                                                    @break

                                                    @default
                                                        Sort By
                                                @endswitch
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'newest', 'page' => 1]) }}"
                                                    class="dropdown-item {{ $sort == 'newest' ? 'active' : '' }}">Newest</a>
                                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'popular', 'page' => 1]) }}"
                                                    class="dropdown-item {{ $sort == 'popular' ? 'active' : '' }}">Popular</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($products->count() > 0)
                            @foreach ($products as $product)
                                <div class="col-lg-4">
                                    <div class="product-item">
                                        <div class="product-image">
                                            <img src="{{ minioUrl($product->image) }}"
                                                alt="{{ $product->product_name }}" class="img-fluid">
                                            <div class="product-action">
                                                <form action="{{ route('cart.addItem') }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <input type="hidden" name="unit_price"
                                                        value="{{ $product->current_price }}">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button type="submit" class="btn btn-link">
                                                        <i class="fa fa-cart-plus"></i>
                                                    </button>
                                                </form>
                                                <a href="{{ route('product.show', $product->id) }}">
                                                    <i class="fa fa-search"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="product-content">
                                            <div class="product-brand text-muted small mb-1">
                                                {{ $product->brand->brand_name ?? 'Unknown Brand' }}
                                            </div>
                                            <div class="title">
                                                <a href="{{ route('product.show', ['id' => $product->id]) }}">
                                                    {{ $product->product_name }}
                                                </a>
                                            </div>
                                            <div class="price">
                                                @if ($product->discounted_price && $product->discounted_price < $product->original_price)
                                                    ${{ number_format($product->discounted_price, 2) }}
                                                    <span>${{ number_format($product->original_price, 2) }}</span>
                                                @else
                                                    ${{ number_format($product->original_price, 2) }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12 text-center py-5">
                                <h5 class="text-muted">No products available</h5>
                                <p class="text-muted">Check back later for new arrivals!</p>
                            </div>
                        @endif
                    </div>

                    <!-- Pagination -->
                    <div class="col-lg-12">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                {{ $products->links() }}
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-md-3">
                    <div class="sidebar-widget category">
                        <h2 class="title">Category</h2>
                        <ul>
                            @foreach ($categories as $category)
                                <li>
                                    <a href="{{ route('product.category', ['id' => $category->id]) }}">
                                        {{ $category->category_name }}
                                    </a>
                                    <span>({{ $category->products->count() }})</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="sidebar-widget brands">
                        <h2 class="title">Brands</h2>
                        <ul>
                            @foreach ($brands as $brand)
                                <li>
                                    <a href="{{ route('product.brand', ['id' => $brand->id]) }}">
                                        {{ $brand->brand_name }}
                                    </a>
                                    <span>({{ $brand->products->count() }})</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Product List End -->
@endsection
