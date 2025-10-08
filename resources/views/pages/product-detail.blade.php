@extends('layouts.app')

@section('title', 'Product - E Shop')

@section('content')
    <!-- Product Detail Start -->
    <div class="product-detail">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="row align-items-center product-detail-top">
                        <div class="col-md-5">
                            <div class="product-slider-single">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="product-content">
                                <div class="title">
                                    <h2>{{ $product->product_name }}</h2>
                                </div>
                                <div class="ratting">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fa fa-star{{ $i <= $product->average_rating ? '' : '-o' }}"></i>
                                    @endfor
                                    <span class="ml-2">({{ $product->rating_count }} reviews)</span>
                                </div>
                                <div class="price">
                                    @if ($product->discounted_price && $product->discounted_price < $product->original_price)
                                        ${{ number_format($product->discounted_price, 2) }}
                                        <span>${{ number_format($product->original_price, 2) }}</span>
                                    @else
                                        ${{ number_format($product->original_price, 2) }}
                                    @endif
                                </div>
                                <div class="quantity">
                                    <h4>Quantity:</h4>
                                    <div class="qty">
                                        <button class="btn-minus" type="button"><i class="fa fa-minus"></i></button>
                                        <input type="text" value="1" id="quantity">
                                        <button class="btn-plus" type="button"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>

                                @if ($product->quantity_in_stock > 0)
                                    <div class="action">
                                        <form action="#" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1" id="quantity-input">
                                            <button type="submit" class="btn btn-link">
                                                <i class="fa fa-cart-plus"></i> Add to Cart
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="alert alert-warning mt-3">
                                        <i class="fa fa-exclamation-triangle"></i> Out of Stock
                                    </div>
                                @endif

                                <div class="product-meta mt-3">
                                    <p><strong>SKU:</strong> {{ $product->product_code }}</p>
                                    <p><strong>Category:</strong> {{ $product->category->category_name ?? 'N/A' }}</p>
                                    <p><strong>Brand:</strong> {{ $product->brand->brand_name ?? 'N/A' }}</p>
                                    <p><strong>Availability:</strong>
                                        @if ($product->quantity_in_stock > 0)
                                            <span class="text-success">In Stock ({{ $product->quantity_in_stock }}
                                                available)</span>
                                        @else
                                            <span class="text-danger">Out of Stock</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row product-detail-bottom">
                        <div class="col-lg-12">
                            <ul class="nav nav-pills nav-justified">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="pill" href="#description">Description</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#specification">Specification</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#reviews">Reviews
                                        ({{ $product->reviews_count ?? 0 }})</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div id="description" class="container tab-pane active"><br>
                                    <h4>Product description</h4>
                                    <p>{{ $product->description }}</p>
                                </div>
                                <div id="specification" class="container tab-pane fade"><br>
                                    <h4>Product specification</h4>
                                    <ul>
                                        <li><strong>Brand:</strong> {{ $product->brand->brand_name ?? 'N/A' }}</li>
                                        <li><strong>Model:</strong> {{ $product->product_name }}</li>
                                        <li><strong>SKU:</strong> {{ $product->product_code }}</li>
                                        <li>
                                            <strong>Category:</strong> {{ $product->category->category_name ?? 'N/A' }}
                                        </li>
                                        <li>
                                            <strong>Availability:</strong>
                                            @if ($product->quantity_in_stock > 0)
                                                In Stock
                                            @else
                                                Out of Stock
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                                <div id="reviews" class="container tab-pane fade"><br>
                                    @if ($product->reviews && $product->reviews->count() > 0)
                                        @foreach ($product->reviews as $review)
                                            <div class="reviews-submitted">
                                                <div class="reviewer">{{ $review->user->name ?? 'Anonymous' }} -
                                                    <span>{{ $review->created_at->format('d M Y') }}</span>
                                                </div>
                                                <div class="ratting">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="fa fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                                                    @endfor
                                                </div>
                                                <p>{{ $review->comment }}</p>
                                            </div>
                                        @endforeach
                                    @else
                                        <p>No reviews yet. Be the first to review this product!</p>
                                    @endif

                                    @auth
                                        <div class="reviews-submit">
                                            <h4>Give your Review:</h4>
                                            <form action="" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <div class="ratting mb-3">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="fa fa-star-o rating-star"
                                                            data-rating="{{ $i }}"></i>
                                                    @endfor
                                                    <input type="hidden" name="rating" id="rating-value" value="5">
                                                </div>
                                                <div class="row form">
                                                    <div class="col-sm-12">
                                                        <textarea name="comment" placeholder="Your review" required></textarea>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <button type="submit" class="btn btn-primary">Submit Review</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    @else
                                        <div class="alert alert-info">
                                            Please <a href="#">login</a> to submit a review.
                                        </div>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($relatedProducts->count() > 0)
                        <div class="related-products">
                            <div class="container">
                                <div class="section-header">
                                    <h3>Related Products</h3>
                                </div>
                            </div>

                            <div class="container">
                                <div class="row product-slider-3">
                                    @foreach ($relatedProducts as $relatedProduct)
                                        <div class="col-lg-3 col-md-4 col-sm-6">
                                            <div class="product-item">
                                                <div class="product-image">
                                                    <img src="{{ asset('storage/' . $relatedProduct->image) }}"
                                                        alt="{{ $relatedProduct->product_name }}">
                                                    <div class="product-action">
                                                        <form action="#" method="POST" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" name="product_id"
                                                                value="{{ $relatedProduct->id }}">
                                                            <input type="hidden" name="quantity" value="1">
                                                            <button type="submit" class="btn btn-link">
                                                                <i class="fa fa-cart-plus"></i>
                                                            </button>
                                                        </form>
                                                        <a href="{{ route('product.show', $relatedProduct->id) }}"
                                                            class="btn btn-link">
                                                            <i class="fa fa-search"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="product-content">
                                                    <div class="product-brand text-muted small mb-1">
                                                        {{ $relatedProduct->brand->brand_name ?? 'Unknown Brand' }}
                                                    </div>
                                                    <div class="title">
                                                        <a href="{{ route('product.show', $relatedProduct->id) }}">
                                                            {{ $relatedProduct->product_name }}
                                                        </a>
                                                    </div>
                                                    <div class="price">
                                                        @if ($relatedProduct->discounted_price && $relatedProduct->discounted_price < $relatedProduct->original_price)
                                                            ${{ number_format($relatedProduct->discounted_price, 2) }}
                                                            <span>${{ number_format($relatedProduct->original_price, 2) }}</span>
                                                        @else
                                                            ${{ number_format($relatedProduct->original_price, 2) }}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Product Detail End -->
@endsection
