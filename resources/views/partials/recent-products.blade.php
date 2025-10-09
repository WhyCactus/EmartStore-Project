<!-- Recent Product Start -->
<div class="recent-product">
    <div class="container">
        <div class="section-header">
            <h3>Recent Products</h3>
        </div>

        @if ($recentProducts->count() > 0)
            <div class="row align-items-center product-slider product-slider-4">
                @foreach ($recentProducts as $product)
                    <div class="col-lg-3">
                        <div class="product-item">
                            <div class="product-image">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}"
                                    class="img-fluid">
                                <div class="product-action">
                                    <form action="#" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
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

                                <!-- Created date -->
                                <div class="product-date text-muted small mt-1">
                                    Added {{ $product->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTR8fHByb2R1Y3R8ZW58MHx8MHx8&auto=format&fit=crop&w=400&q=60"
                    alt="No products" class="img-fluid mb-3" style="max-width: 200px;">
                <h5 class="text-muted">No recent products available</h5>
                <p class="text-muted">Check back later for new arrivals!</p>
            </div>
        @endif
    </div>
</div>
<!-- Recent Product End -->
