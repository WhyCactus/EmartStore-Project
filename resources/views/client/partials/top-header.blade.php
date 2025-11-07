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
                            <div class="bell gap-5">
                                <a href="#"><i class="fa fa-bell"></i></a>
                            </div>
                            <div class="cart">
                                <a href="{{ route('cart.list') }}"><i class="fa fa-cart-plus"></i></a>
                            </div>
                            <a href="#" class="dropdown-toggle"
                                data-toggle="dropdown">{{ Auth::user()->username }}</a>
                            <div class="dropdown-menu">
                                <a href="{{ route('my-account.orders') }}" class="dropdown-item">My Account</a>
                                @if (Auth::user()->role_id == 1)
                                    <a href="/admin/dashboard" class="dropdown-item">Dashboard</a>
                                @endif
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Top Header End -->
