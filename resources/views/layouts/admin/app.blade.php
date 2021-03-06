<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @if (auth()->user()->role == 0)
        <title>@yield('title') LifeWear Admin</title>
    @else
        <title>@yield('title') LifeWear Employee</title>
    @endif
    <link href="{{ asset('images/favicon.ico') }}" rel="shortcut icon" type="image/x-icon" />
    <link href="{{ asset('css/bootstrap.css?v=1.1') }}" rel="stylesheet" type="text/css" />
    <!-- custom style -->
    <link href="{{ asset('css/ui.css?v=1.1') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/responsive.css?v=1.1') }}" rel="stylesheet" />
    <!-- iconfont -->
    <link rel="stylesheet" href="{{ asset('fonts/material-icon/css/round.css') }}" />
    @stack('css')
</head>

<body>
    <aside class="navbar-aside" id="offcanvas_aside">
        <div class="aside-top">
            <a href="{{ route('dashboard') }}" class="brand-wrap">
                <img src="{{ asset('images/logo.png') }}" height="42" class="logo" alt="Shop LifeWear Admin" />
            </a>
            <div>
                <button class="btn btn-icon btn-aside-minimize">
                    <i class="text-muted material-icons md-menu_open"></i>
                </button>
            </div>
        </div>

        <nav>
            <ul class="menu-aside">
                <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('dashboard') }}">
                        <i class=" icon material-icons md-home"></i>
                        <span class="text">Tổng quan</span>
                    </a>
                </li>
                @if (auth()->user()->role == 0)
                    <li class="menu-item has-submenu {{ request()->is('product/*') ? 'active' : '' }}">
                        <a class="menu-link" href="#">
                            <i class="icon material-icons md-shopping_bag"></i>
                            <span class="text">Sản phẩm</span>
                        </a>
                        <div class="submenu">
                            <a href="{{ route('product.list') }}">Danh sách sản phẩm</a>
                            <a href="{{ route('product.create') }}">Thêm sản phẩm</a>
                        </div>
                    </li>

                    <li class="menu-item has-submenu {{ request()->is('category/*') ? 'active' : '' }}">
                        <a class="menu-link" href="#">
                            <i class="icon material-icons md-local_offer"></i>
                            <span class="text">Danh mục</span>
                        </a>
                        <div class="submenu">
                            <a href="{{ route('category.list') }}">Danh sách danh mục</a>
                            <a href="{{ route('category.create') }}">Thêm danh mục</a>
                        </div>
                    </li>

                    <li class="menu-item has-submenu {{ request()->is('supplier/*') ? 'active' : '' }}">
                        <a class="menu-link" href="#">
                            <i class="icon material-icons md-watch"></i>
                            <span class="text">Nhà cung cấp / Brand</span>
                        </a>
                        <div class="submenu">
                            <a href="{{ route('supplier.list') }}">Danh sách nhà cung cấp</a>
                            <a href="{{ route('supplier.create') }}">Thêm nhà cung cấp</a>
                        </div>
                    </li>

                @endif
                <li class="menu-item has-submenu {{ request()->is('order/*') ? 'active' : '' }}">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-shopping_cart"></i>
                        <span class="text">Đơn hàng</span>
                    </a>
                    <div class="submenu">
                        <a href="{{ route('order.list') }}">Danh sách đơn hàng</a>
                        <a href="{{ route('order.create') }}">Thêm đơn hàng</a>
                    </div>
                </li>

                @if (auth()->user()->role == 0)
                    <li class="menu-item has-submenu {{ request()->is('coupon/*') ? 'active' : '' }}">
                        <a class="menu-link" href="#">
                            <i class="icon material-icons md-card_giftcard"></i>
                            <span class="text">Mã giảm giá</span>
                        </a>
                        <div class="submenu">
                            <a href="{{ route('coupon.list') }}">Danh sách mã giảm giá</a>
                            <a href="{{ route('coupon.create') }}">Thêm mã giảm giá</a>
                        </div>
                    </li>

                    <li class="menu-item has-submenu {{ request()->is('receive-note/*') ? 'active' : '' }}">
                        <a class="menu-link" href="#">
                            <i class="icon material-icons md-note"></i>
                            <span class="text">Phiếu nhập</span>
                        </a>
                        <div class="submenu">
                            <a href="{{ route('received-note.list') }}">Danh sách phiếu nhập</a>
                            <a href="{{ route('received-note.create') }}">Thêm phiếu nhập</a>
                        </div>
                    </li>
                    <li class="menu-item {{ request()->routeIs('user.list') ? 'active' : '' }}">
                        <a class="menu-link" href="{{ route('user.list') }}">
                            <i class=" icon material-icons md-account_circle"></i>
                            <span class="text">Quản lý nhân viên</span>
                        </a>
                    </li>
                    @endif
            </ul>
        </nav>
    </aside>

    <main class="main-wrap">
        <header class="main-header navbar">
            <div class="col-search">
                <form class="search-form">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search term" />
                        <button class="btn btn-light bg" type="button">
                            <i class="material-icons md-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-nav">
                <button class="btn btn-icon btn-mobile me-auto" data-trigger="#offcanvas_aside"> <i
                        class="md-28 material-icons md-menu"></i> </button>
                <ul class="nav">
                    <li class="dropdown nav-item">
                        <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#">
                            <img class="img-xs rounded-circle"
                                src="{{ asset('images/avatar/' . (auth()->user()->avatar_image == '' ? 'default.png' : auth()->user()->avatar_image)) }}"
                                alt="" /></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#">Cài đặt</a>
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Đăng xuất</button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </header>

        <section class="content-main">
            @if (session('info'))
                <div class="alert alert-info">{{ session('info') }}</div>
            @endif

            @if ($errors->any())
                {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
            @endif

            @yield('content-main')
        </section>
    </main>

    <script src="{{ asset('js/jquery-3.5.0.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/script.js') }}" type="text/javascript"></script>
    @stack('js')
</body>

</html>
