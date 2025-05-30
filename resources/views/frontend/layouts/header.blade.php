<header class="site-header">
    <div class="top-header bg-dark text-light py-2">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <span><i class="fas fa-phone"></i> Hotline: 1900 xxxx</span>
                    <span class="ml-3"><i class="fas fa-envelope"></i> Email: support@example.com</span>
                </div>
                <div class="col-md-6 text-right">
                    @auth
                        <a href="{{ route('client.account.index') }}" class="text-light mr-3">
                            <i class="fas fa-user"></i> Tài khoản
                        </a>
                        <form action="{{ route('client.auth.logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link text-light p-0">
                                <i class="fas fa-sign-out-alt"></i> Đăng xuất
                            </button>
                        </form>
                    @else
                        <a href="{{ route('client.auth.login') }}" class="text-light mr-3">
                            <i class="fas fa-sign-in-alt"></i> Đăng nhập
                        </a>
                        <a href="{{ route('client.auth.register') }}" class="text-light">
                            <i class="fas fa-user-plus"></i> Đăng ký
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('client.home') }}">
                <img src="{{ asset('frontend/images/logo.png') }}" alt="Logo" height="50">
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.home') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            Danh mục
                        </a>
                        <ul class="dropdown-menu">
                            @foreach($categories ?? [] as $category)
                                <li>
                                    <a class="dropdown-item" href="{{ route('client.category.show', $category->slug) }}">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.product.index') }}">Sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.contact.index') }}">Liên hệ</a>
                    </li>
                </ul>

                <form class="d-flex me-3" action="{{ route('client.product.index') }}" method="GET">
                    <input class="form-control me-2" type="search" name="search" placeholder="Tìm kiếm...">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

                <div class="cart-icon">
                    <a href="{{ route('client.cart.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="badge bg-primary cart-count">{{ Cart::getTotalQuantity() }}</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>