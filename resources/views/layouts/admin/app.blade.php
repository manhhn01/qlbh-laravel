<!DOCTYPE html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>@yield('title') LifeWear Admin</title>
    <link href="{{ asset('images/favicon.ico') }}" rel="shortcut icon" type="image/x-icon" />
    <link href="{{ asset('css/bootstrap.css?v=1.1') }}" rel="stylesheet" type="text/css" />
    <!-- custom style -->
    <link href="{{asset('css/ui.css?v=1.1')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/responsive.css?v=1.1')}}" rel="stylesheet" />
    <!-- iconfont -->
    <link rel="stylesheet" href="{{asset('fonts/material-icon/css/round.css')}}" />
</head>

<body>
    <aside class="navbar-aside" id="offcanvas_aside">
        <div class="aside-top">
            <a href="{{ route('dashboard') }}" class="brand-wrap">
                <img src="{{asset('images/logo.png')}}" height="42" class="logo" alt="Shop LifeWear Admin" />
            </a>
            <div>
                <button class="btn btn-icon btn-aside-minimize">
                    <i class="text-muted material-icons md-menu_open"></i>
                </button>
            </div>
        </div>

        <nav>
            <ul class="menu-aside">
                <li class="menu-item {{request()->routeIs('dashboard') ? "active" : ""}}">
                    <a class="menu-link" href="{{ route('dashboard') }}"">
            <i class=" icon material-icons md-home"></i>
                        <span class="text">Tổng quan</span>
                    </a>
                </li>

                <li class="menu-item has-submenu {{request()->is('product/*') ? "active" : ""}}">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-shopping_bag"></i>
                        <span class="text">Sản phẩm</span>
                    </a>
                    <div class="submenu">
                        <a href="{{ route('product.list') }}">Danh sách sản phẩm</a>
                        <a href="{{ route('product.create') }}">Thêm sản phẩm</a>
                    </div>
                </li>

                <li class="menu-item has-submenu {{request()->is('category/*') ? "active" : ""}}">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-local_offer"></i>
                        <span class="text">Danh mục</span>
                    </a>
                    <div class="submenu">
                        <a href="{{ route('category.list') }}">Danh sách danh mục</a>
                        <a href="{{ route('category.create') }}">Thêm danh mục</a>
                    </div>
                </li>

                <li class="menu-item has-submenu">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-shopping_bag"></i>
                        <span class="text">Đơn hàng</span>
                    </a>
                    <div class="submenu">
                        <a href="#">...</a>
                        <a href="#">...</a>
                    </div>
                </li>

                <li class="menu-item has-submenu">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-shopping_bag"></i>
                        <span class="text">new menu</span>
                    </a>
                    <div class="submenu">
                        <a href="#">Product list view</a>
                        <a href="page-new menu-table.html">...</a>
                        <a href="page-new menu-grid.html">Product grid</a>
                        <a href="page-new menu-grid-2.html">Product grid 2</a>
                        <a href="page-categories.html">Categories</a>
                    </div>
                </li>

            </ul>
        </nav>
    </aside>

    <main class="main-wrap">
        <header class="main-header navbar">
            <div class="col-search">
                <form class="searchform">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search term" />
                        <button class="btn btn-light bg" type="button">
                            <i class="material-icons md-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-nav">
                <ul class="nav">
                    <li class="dropdown nav-item">
                        <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#">
                            <img class="img-xs rounded-circle" src="{{ asset("images/avatar/".(auth()->user()->avatar_image == "" ? 'default.png' :  auth()->user()->avatar_image)) }}" alt="" /></a>
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
            {{--
            @error('message')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror --}}
            {{--
            @error('message')
            <div class="mb-3 alert alert-danger">{{ $message }}</div>
            @enderror --}}
            @if($errors->any())
            {!!
            implode('', $errors->all('<div class="alert alert-danger">:message</div>'))
            !!}
            @endif

            @yield('content-main')
        </section>
    </main>

    <script src="{{asset('js/jquery-3.5.0.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>

    <!-- Custom JS -->
    <script src="{{asset('js/script.js?v=1.0')}}" type="text/javascript"></script>
    @yield('javascript')
    @stack('js')
</body>

</html>
