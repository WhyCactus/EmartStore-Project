<!-- Category Start -->
<div class="category-section">
    <div class="container">
        <h2 class="section-title">Categories</h2>
        <div class="row">
            @foreach ($categories as $category)
                <div class="col-md-4 col-sm-6 mb-4">
                    <div class="category-card">
                        <div class="category-image">
                            <a href="{{ route('product.category', ['id' => $category->id]) }}">
                                <img src="{{ asset('storage/' . $category->image) }}" alt="Category Name" />
                            </a>
                        </div>
                        <div class="category-info">
                            <h3 class="category-title">
                                <a href="{{ route('product.category', ['id' => $category->id]) }}">
                                    {{ $category->category_name }}
                                </a>
                            </h3>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Category End -->
