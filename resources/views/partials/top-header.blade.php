<!-- Top Header Start -->
<div class="top-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-3">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo">
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="search">
                    <input type="text" placeholder="Search">
                    <button><i class="fa fa-search"></i></button>
                </div>
            </div>
            <div class="col-md-3">
                <div class="user">
                    <div class="dropdown">
                        @auth()
                            <a href="#" class="dropdown-toggle"
                                data-toggle="dropdown">{{ Auth::user()->username }}</a>
                            <div class="dropdown-menu">
                                <a href="{{ route('my-account') }}" class="dropdown-item">My Account</a>
                                @if (Auth::user()->role_id == 1)
                                    <a href="#" class="dropdown-item">Dashboard</a>
                                @endif
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('login') }}">Login</a>
                        @endauth

                    </div>
                    <div class="cart">
                        <i class="fa fa-cart-plus"></i>
                        <span>(0)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Top Header End -->
