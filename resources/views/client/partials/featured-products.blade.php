<!-- Featured Product Start -->
<div class="featured-product">
    <div class="container">
        <div class="section-header">
            <h3>Featured Product</h3>
        </div>

        @if ($featuredProducts->count() > 0)
            <div class="row align-items-center product-slider product-slider-4">
                @foreach ($featuredProducts as $product)
                    <div class="col-lg-3">
                        <div class="product-item">
                            <div class="product-image">
                                <img src="{{ $product->image }}" alt="{{ $product->product_name }}"
                                    class="img-fluid">
                                <div class="product-action">
                                    <form action="{{ route('cart.addItem') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="unit_price" value="{{ $product->current_price }}">
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
                                    <a href="{{ route('product.show', $product->id) }}">
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

                                @if ($product->quantity_in_stock <= 5 && $product->quantity_in_stock > 0)
                                    <div class="stock-warning text-warning small">
                                        Only {{ $product->quantity_in_stock }} left!
                                    </div>
                                @elseif($product->quantity_in_stock == 0)
                                    <div class="stock-warning text-danger small">
                                        Out of Stock
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-4">
                <p class="text-muted">No featured products available at the moment.</p>
            </div>
        @endif
    </div>
</div>
<!-- Featured Product End -->
