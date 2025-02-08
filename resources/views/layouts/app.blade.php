<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/scripts.js') }}" defer></script>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}" defer></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div id="app">
        <header class="p-3 mb-3 border-bottom">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="{{ url('/') }}" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
                        <svg class="me-2" xmlns="http://www.w3.org/2000/svg" xmlns:v="https://svgstorm.com"
                        viewBox = "0 0 500 500"
                        width="24"
                        height="24">
                        <g fill="#1a71bd" fill-opacity="0.99" stroke="None">
                        <path d="
                        M 5.00 492.00
                        C 44.23 492.13 88.25 491.82 127.00 492.00 C 165.75 492.18 212.00 491.66 249.00 492.00 C 286.00 492.34 320.34 485.39 350.77 471.77 C 381.20 458.15 399.33 444.05 422.75 421.75 C 446.18 399.46 459.08 378.78 473.23 350.23 C 487.37 321.68 495.18 283.21 495.00 250.00 C 494.82 216.79 487.75 177.98 473.77 149.23 C 459.79 120.48 446.01 100.80 422.75 78.25 C 399.50 55.70 381.55 41.67 351.08 27.92 C 320.60 14.18 286.13 7.27 249.00 8.00 C 211.87 8.73 165.82 7.62 127.00 8.00 C 88.18 8.38 44.28 7.71 5.00 8.00
                        C 5.00 169.33 5.00 330.67 5.00 492.00
                        M 93.00 403.00
                        C 93.00 300.67 93.00 198.33 93.00 96.00
                        C 125.46 96.04 164.17 95.95 196.00 96.00 C 227.83 96.05 266.11 94.08 294.07 101.93 C 322.03 109.77 339.52 121.08 359.70 140.30 C 379.87 159.52 390.88 178.45 399.93 204.07 C 408.98 229.70 408.90 268.55 400.22 294.22 C 391.54 319.89 381.07 339.56 360.75 358.75 C 340.43 377.94 323.33 389.18 295.33 397.33 C 267.33 405.47 228.99 402.82 197.00 403.00 C 165.01 403.18 125.66 402.86 93.00 403.00 Z"/>
                        </g>
                        <g fill="#1a71bd" fill-opacity="0.99" stroke="None">
                        <path d="
                        M 113.00 383.00
                        C 148.80 384.13 194.16 381.49 229.00 383.00 C 263.84 384.51 297.43 380.11 323.92 361.92 C 350.41 343.73 364.18 326.44 376.23 298.23 C 388.28 270.02 389.15 229.42 376.77 201.23 C 364.40 173.04 350.26 156.68 324.23 137.77 C 298.20 118.86 263.65 115.62 229.00 117.00 C 194.35 118.38 148.66 115.96 113.00 117.00
                        C 113.00 205.67 113.00 294.33 113.00 383.00
                        M 202.00 294.00
                        C 202.00 264.33 202.00 234.67 202.00 205.00
                        C 227.54 206.47 263.30 198.95 282.75 217.25 C 302.20 235.55 303.17 262.89 283.75 281.75 C 264.33 300.61 227.71 292.37 202.00 294.00 Z"/>
                        </g>
                        </svg>
                    </a>

                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        <li><a href="#" class="nav-link px-2 link-secondary">Trang chủ</a></li>
                        <li><a href="{{ route('list.topic') }}" class="nav-link px-2 link-dark">Luyện nghe</a></li>
                        <li><a href="{{ route('home.vocabulary') }}" class="nav-link px-2 link-dark">Từ vựng</a></li>
                        <li><a href="{{ route('home.exam') }}" class="nav-link px-2 link-dark">Thi thử</a></li>
                    </ul>

                    <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
                    <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
                    </form>

                    @guest
                        @if (Route::has('login'))
                                <a class="btn btn-outline-primary me-2" href="{{ route('login') }}">{{ __('Login') }}</a>
                        @endif

                        @if (Route::has('register'))
                                <a class="btn btn-primary" href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endif
                    @else
                        <div class="dropdown text-end">
                            <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
                            </a>
                            <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1" style="">
                                <li><a class="dropdown-item" href="#">Trang cá nhân</a></li>
                                <li><a class="dropdown-item" href="#">Bài đăng</a></li>
                                <li><a class="dropdown-item" href="#">Cài đặt</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Đăng xuất</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>
            </div>
        </header>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{asset('js/scripts.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="{{asset('js/datatables-simple-demo.js')}}"></script>
</html>
