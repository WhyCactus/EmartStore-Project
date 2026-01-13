<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                @can('user')
                    <a class="nav-link" href="{{ route('admin.users') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                        Users
                    </a>
                @endcan

                @can('product')
                    <a href="{{ route('admin.product.products') }}" class="nav-link">
                        <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                        Products
                    </a>
                @endcan

                @can('category')
                    <a href="{{ route('admin.category.categories') }}" class="nav-link">
                        <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                        Categories
                    </a>
                @endcan

                @can('brand')
                    <a href="{{ route('admin.brand.brands') }}" class="nav-link">
                        <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                        Brands
                    </a>
                @endcan

                @can('order')
                    <a href="{{ route('admin.orders') }}" class="nav-link">
                        <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                        Orders
                    </a>
                @endcan
                </a>

                @can('role')
                    <a href="{{ route('admin.roles.index') }}" class="nav-link">
                        <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                        Roles
                    </a>
                @endcan

                <a href="{{ route('admin.chat') }}" class="nav-link">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Chat
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{ Auth::user()->username ?? 'Start Bootstrap' }}
        </div>
    </nav>
</div>
