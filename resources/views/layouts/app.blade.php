<!DOCTYPE html>

<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <title>@yield('title') | LifeWear Admin</title>
  <link href="{{ asset('images/favicon.ico') }}" rel="shortcut icon" type="image/x-icon"/>
  <link href="{{ asset('css/bootstrap.css?v=1.1') }}" rel="stylesheet" type="text/css"/>
  <!-- custom style -->
  <link href="{{asset('css/ui.css?v=1.1')}}" rel="stylesheet" type="text/css"/>
  <link href="{{asset('css/responsive.css?v=1.1')}}" rel="stylesheet"/>
  <!-- iconfont -->
  <link rel="stylesheet" href="{{asset('fonts/material-icon/css/round.css')}}"/>
</head>

<body>
@auth
  <aside class="navbar-aside" id="offcanvas_aside">
    <div class="aside-top">
      <a href="page-index-1.html" class="brand-wrap">
        <img src="{{asset('images/logo.png')}}" height="42" class="logo" alt="Shop LifeWear Admin"/>
      </a>
      <div>
        <button class="btn btn-icon btn-aside-minimize">
          <i class="text-muted material-icons md-menu_open"></i>
        </button>
      </div>
    </div>

    <nav>
      <ul class="menu-aside">
        <li class="menu-item active">
          <a class="menu-link" href="page-index-1.html">
            <i class="icon material-icons md-home"></i>
            <span class="text">Dashboard</span>
          </a>
        </li>
        <li class="menu-item has-submenu">
          <a class="menu-link" href="page-products-list.html">
            <i class="icon material-icons md-shopping_bag"></i>
            <span class="text">Products</span>
          </a>
          <div class="submenu">
            <a href="page-products-list.html">Product list view</a>
            <a href="page-products-table.html">Product table view</a>
            <a href="page-products-grid.html">Product grid</a>
            <a href="page-products-grid-2.html">Product grid 2</a>
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
            <input type="text" class="form-control" placeholder="Search term"/>
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
              <img class="img-xs rounded-circle" src="{{ '/path/to/user/img' }}" alt=""/></a>
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
      @yield('content-main')
    </section>
  </main>
@endauth

@guest
  <main>
    <header class="main-header navbar">
      <div class="col-brand">
        <a href="page-index-1.html" class="brand-wrap">
          <img src="{{asset('images/logo.png')}}" height="46" class="logo" alt="Ecommerce dashboard template">
        </a>
      </div>
    </header>
    <section class="content-main">
      @yield('auth-form')
    </section>
  </main>
@endguest


<script src="{{asset('js/jquery-3.5.0.min.js')}}"></script>
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>

<!-- Custom JS -->
<script src="{{asset('js/script.js?v=1.0')}}" type="text/javascript"></script>

</body>

</html>
