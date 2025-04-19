<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DTU English Hub</title>

    <link rel="icon" href="/favicon.ico" type="image/x-icon" />
    <!-- Scripts -->
    <script src="{{ asset('js/scripts.js') }}" defer></script>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}" defer></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    {{-- <link href="vendor/aos/aos.css" rel="stylesheet"> --}}
    <link href="vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div id="app">
        <header id="header" class="header d-flex align-items-center fixed-top">
            <div class="container-fluid container-xl position-relative d-flex align-items-center">
              <a href="{{ route('home') }}" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none logo d-flex align-items-center me-auto">
                <img src="img/logo.png" alt="">
                <h1 class="sitename">DTU English Hub</h1>
              </a>
              <nav id="navmenu" class="navmenu">
                <ul>
                  <li><a href="{{ route('home') }}" class="{{ request()->is('home') ? 'active' : '' }}">Trang chủ</a></li>
                  <li><a href="{{ route('list.topic') }}" class="{{ request()->is('topic*') ? 'active' : '' }}">Luyện nghe</a></li>
                  <li><a href="{{ route('home.vocabulary') }}" class="{{ request()->is('vocabulary*') ? 'active' : '' }}">Từ vựng</a></li>
                  <li><a href="{{ route('home.exam') }}" class="{{ request()->is('exam*') ? 'active' : '' }}">Thi thử</a></li>
                  <li><a href="{{ route('home.pronounce') }}" class="{{ request()->is('pronounce*') ? 'active' : '' }}">IPA</a></li>
                  <li><a href="{{ route('voice.interaction') }}" class="{{ request()->is('voice-interaction*') ? 'active' : '' }}">Trợ lý AI</a></li>
                  <li><a href="{{ route('home.community') }}" class="{{ request()->is('community*') ? 'active' : '' }}">Cộng đồng</a></li>
                  <li><a href="{{ route('home.donate') }}" class="{{ request()->is('donate*') ? 'active' : '' }}">Ủng hộ</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
              </nav>
              @guest
                    @if (Route::has('login'))
                            <a class="cta-btn" href="{{ route('login') }}">Đăng nhập</a>
                    @endif
          
                    @if (Route::has('register'))
                            <a class="cta-btn" href="{{ route('register') }}">Đăng ký</a>
                    @endif
                @else
                    <div class="dropdown text-end">
                        <a href="#" class="d-block link-dark text-decoration-none ms-4" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}"
                                 class="rounded-circle me-3"
                                 width="36" height="36" alt="Avatar">
                        </a>
                        <ul class="dropdown-menu text-small dropdown-menu-end profile-dropdown mt-2" aria-labelledby="dropdownUser1" style="">
                            <li class="p-3 d-flex align-items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}"
                                    class="rounded-circle"
                                    width="50" height="50" alt="Avatar">
                                <div>
                                    <div class="fw-semibold">{{ Auth::user()->name }}</div>
                                    <div class="text-muted">{{ '@' . \Illuminate\Support\Str::before(Auth::user()->email, '@') }}</div>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Trang cá nhân</a></li>
                            <li><a class="dropdown-item" href="#">Bài viết của tôi</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.setting') }}">Cài đặt</a></li>
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
          </header>

        <main class="">
            @yield('content')
        </main>

        <footer id="footer" class="footer dark-background">
            <div class="container footer-top">
                <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="{{ route('home') }}" class="logo d-flex align-items-center">
                    <span class="sitename">DTU English Hub</span>
                    </a>
                    <div class="footer-contact pt-2">
                    <p>03 Quang Trung</p>
                    <p>Da Nang</p>
                    <p><strong>Phone:</strong> <span>+1 5589 55488 55</span></p>
                    <p><strong>Email:</strong> <span>duytan@dtu.edu.vn</span></p>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Liên kết</h4>
                    <ul>
                    <li><i class="bi bi-chevron-right"></i> <a href="{{ route('home') }}" class="{{ request()->is('home') ? 'active' : '' }}">Trang chủ</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="#">Cộng đồng</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="{{ route('home.donate') }}" class="{{ request()->is('home/donate*') ? 'active' : '' }}">Ủng hộ</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Tính năng</h4>
                    <ul>
                    <li><i class="bi bi-chevron-right"></i> <a href="{{ route('list.topic') }}" class="{{ request()->is('home/topic*') ? 'active' : '' }}">Luyện nghe</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="{{ route('home.vocabulary') }}" class="{{ request()->is('home/vocabulary*') ? 'active' : '' }}">Học từ vựng</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="{{ route('home.exam') }}" class="{{ request()->is('home/exam*') ? 'active' : '' }}">Bài kiểm tra</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-12 footer-newsletter">
                    <h4>Đừng bỏ lỡ nội dung hay</h4>
                    <p>Đăng ký ngay để nhận tài liệu học tiếng Anh miễn phí mỗi tuần!</p>
                    <form action="forms/newsletter.php" method="post" class="php-email-form">
                    <div class="newsletter-form"><input type="email" name="email"><input type="submit" value="Đăng ký"></div>
                    <div class="loading">Loading</div>
                    <div class="error-message"></div>
                    <div class="sent-message">Your subscription request has been sent. Thank you!</div>
                    </form>
                </div>

                </div>
            </div>

            <div class="container copyright text-center">
                <p>© <span>Copyright</span> <strong class="px-1 sitename">NCKH 2025</strong> <span>Duy Tan University</span></p>
            </div>

        </footer>
    </div>
    @yield('scripts')
</body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{asset('js/scripts.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="{{asset('js/datatables-simple-demo.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script src="{{asset('js/wow.js')}}"></script>
    <script>
        new WOW({
            animateClass: 'animate__animated',
        }).init();
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            new Swiper(".mySwiper", {
                loop: true,
                speed: 600,
                autoplay: {
                    delay: 5000
                },
                slidesPerView: "auto",
                pagination: {
                    el: ".swiper-pagination",
                    type: "bullets",
                    clickable: true
                }
            });
        });
    </script>
</html>
