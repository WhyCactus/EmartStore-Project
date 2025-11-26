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
                    @auth()
                        <div class="bell">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="notificationBell">
                                <i class="fa fa-bell"></i>
                                <span class="notification-badge" id="notificationCount" style="display: none">0</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right notification-menu" id="notificationMenu">
                                <div class="notification-header">
                                    <span class="text-white">Notifications</span>
                                    <a href="#" id="markAllRead">Mark all as read</a>
                                </div>
                                <div class="notification-list" id="notificationList">
                                    <div class="notification-empty">
                                        <i class="fa fa-bell-slash"></i>
                                        <p>No new notifications</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cart">
                            <a href="{{ route('cart.list') }}"><i class="fa fa-cart-plus"></i></a>
                        </div>
                        <div class="dropdown">
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

@auth
    <div class="toast-container position-fixed" style="top: 80px; right: 20px; z-index: 9999;">
        <div id="notificationToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-primary text-white justify-content-between">
                <div>
                    <i class="fa fa-bell me-2"></i>
                    <strong class="me-auto">New Notification</strong>
                </div>
                <div>
                    <small id="toastTime">Just now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
            <div class="toast-body" id="toastBody">
                <!-- Notification message will be inserted here -->
            </div>
        </div>
    </div>
@endauth
<!-- Top Header End -->
