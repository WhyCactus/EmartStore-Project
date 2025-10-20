<!-- Header Start -->
<div class="header">
    <div class="container">
        <nav class="navbar navbar-expand-md bg-dark navbar-dark">
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav m-auto">
                    <a href="{{ route('home') }}" class="nav-item nav-link active">Home</a>
                    <a href="{{ route('product.list') }}" class="nav-item nav-link">Products</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">More</a>
                        <div class="dropdown-menu">
                            {{-- @foreach ($categories as $category)
                                <a href="{{ route('product.list', ['id' => $category->id]) }}" class="dropdown-item">
                                    {{ $category->category_name }}
                                </a>
                            @endforeach --}}
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- Header End -->
