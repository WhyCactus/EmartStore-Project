<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                <a class="nav-link" href="{{ route('admin.users') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Users
                </a>

                <a href="{{ route('admin.product.products') }}" class="nav-link">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Products
                </a>

                <a href="{{ route('admin.category.categories') }}" class="nav-link">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Categories
                </a>

                <a href="{{ route('admin.brand.brands') }}" class="nav-link">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Brands
                </a>

                <a href="{{ route('admin.orders') }}" class="nav-link">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Orders
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{ Auth::user()->username ?? 'Start Bootstrap' }}
        </div>
    </nav>
</div>
