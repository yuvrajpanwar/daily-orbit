<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Daily Orbit</title>
    <meta name="description" content="Daily Orbit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}"> 
    <link rel="stylesheet" href="{{ asset('assets/css/slicknav.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}"> --}}
    {{-- Vite will inject the built CSS/JS in dev & prod --}}
    @vite(['resources/js/app.js'])
    {{-- not in use  --}}
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">
    --}}
    <style>
        .header-social,
        #navigation {
            margin-bottom: 0 !important;
        }

        .main-header .nav-search i {
            padding: 20px 30px !important;
        }

        .header-area .header-bottom .header-social {
            padding: 20px 30px !important;
        }

        .main-header .main-menu ul li a {
            padding: 20px 25px !important;
        }

        .logo-spin-round {
            animation: spin 4s linear infinite;
            /* 4s = speed, adjust as needed */
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* Smooth bouncy transitions for the hamburger bars */
        .slicknav_icon-bar {
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            transform-origin: center;
        }

        /* Cross transformation when active */
        .slicknav_icon.active .slicknav_icon-bar:first-child {
            transform: rotate(45deg) translate(6px, 6px);
        }

        .slicknav_icon.active .slicknav_icon-bar:nth-child(2) {
            opacity: 0;
            transform: translateX(-20px);
        }

        .slicknav_icon.active .slicknav_icon-bar:last-child {
            transform: rotate(-45deg) translate(6px, -6px);
        }

        @media (max-width: 768px) {
            .not-for-mobile {
                display: none !important;
            }
        }
    </style>

    @stack('css')
</head>

<body>
    <!-- Preloader Start -->
    <div id="preloader-active" style="height: 100vh;width:100vw">
        <div class="preloader  d-flex align-items-center justify-content-center"
            style="height: 100vh;width:100vw;right:auto">
            <div class="preloader-inner position-relative">
                <img src="assets/img/logo/logo-circle.png" height="100px" class="preloader-circle"
                    style="border: none !important;">
            </div>
        </div>
    </div>
    <!-- Preloader End -->
    <header>
        <!-- Header Start -->
        <div class="header-area">
            <div class="main-header ">
                <div class="header-mid gray-bg">
                    <div class="container">
                        <div class="row d-flex align-items-center">
                            <!-- Logo -->
                            <div class="col-xl-4 col-lg-4 col-md-4 d-none d-md-block">
                                <div class="logo">
                                    <a href="index.html" style="display: flex;height:60px;width:fit-content;">
                                        <img src="assets/img/logo/logo-text.png" alt="Daily Orbit Logo">
                                        <img src="assets/img/logo/logo-circle.png" class="logo-spin-round"
                                            alt="Daily Orbit Logo">
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-8 col-lg-8 col-md-8">
                                <div class="header-banner f-right ">
                                    <img src="assets/img/gallery/header_card.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header-bottom header-sticky">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-xl-8 col-lg-8 col-md-12 header-flex">
                                <!-- sticky -->
                                <div class="sticky-logo my-1">
                                    <div class="d-flex">
                                        <div class="my-dropdown" data-dropdown
                                            style="
                                                    margin-top: auto;
                                                    margin-bottom: auto;
                                                    margin-right: 20px;
                                                    /* margin-left: 20px; */
                                                    padding: 1rem;
                                                    color: white;
                                                    border: 1px solid white;
                                                    border-radius: 10px;
                                            ">
                                            <div class="my-dropdown-toggle p-0 m-0">
                                                <i class="fa fa-user"></i>
                                            </div>
                                            <div id="userMenu" class="my-dropdown-menu" role="menu"
                                                aria-hidden="true">
                                                @if (Auth::check())
                                                    <a class="my-dropdown-item" href="{{ route('account.index') }}">
                                                        <i class="fa fa-user-circle" style="margin-right:6px"></i> My
                                                        Account
                                                    </a>
                                                    <div class="my-dropdown-divider" role="separator"></div>
                                                    <a class="my-dropdown-item" href="#"
                                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                        <i class="fa fa-sign-out-alt" style="margin-right:6px"></i>
                                                        Logout
                                                    </a>
                                                @else
                                                    @if (request()->routeIs('login'))
                                                        <a class="my-dropdown-item" href="{{ route('register') }}">
                                                            <i class="fa fa-user-plus" style="margin-right:6px"></i>
                                                            Register
                                                        </a>
                                                    @else
                                                        <a class="my-dropdown-item" href="{{ route('login') }}">
                                                            <i class="fa fa-sign-in-alt" style="margin-right:6px"></i>
                                                            Login
                                                        </a>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <a href="index.html" style="display: flex;height:60px;width:fit-content;">
                                            <img src="assets/img/logo/logo-text-white.png" alt="Daily Orbit Logo">
                                            <img src="assets/img/logo/logo-circle-white.png" class="logo-spin-round"
                                                style="padding:.7rem 0;" alt="Daily Orbit Logo">
                                        </a>
                                    </div>
                                </div>
                                <!-- Main-menu -->
                                <div class="main-menu d-none d-md-block">
                                    <nav>
                                        <ul id="navigation">
                                            <li><a href="index.html">Home</a></li>
                                            <li><a href="about.html">about</a></li>
                                            <li><a href="categori.html">Category</a></li>
                                            <li><a href="latest_news.html">Latest News</a></li>
                                            <li><a href="#">Pages</a>
                                                <ul class="submenu">
                                                    <li><a href="blog.html">Blog</a></li>
                                                    <li><a href="blog_details.html">Blog Details</a></li>
                                                    <li><a href="elements.html">Element</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="contact.html">Contact</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 not-for-mobile">
                                <div class="header-right f-right d-lg-block"
                                    style="border: 1px solid white;border-radius:5px;">
                                    @if (Auth::check())
                                        <div class="my-dropdown" data-dropdown>
                                            <button type="button" class="my-dropdown-toggle" aria-haspopup="true"
                                                aria-expanded="false" aria-controls="userMenu">
                                                <i class="fa fa-user" aria-hidden="true"
                                                    style="margin-right:6px"></i>
                                                <span class="my-user-name">
                                                    {{ strlen(Auth::user()->name) > 15 ? substr(Auth::user()->name, 0, 15) . '...' : Auth::user()->name }}
                                                </span>
                                                <i class="fa fa-chevron-down my-dropdown-icon" aria-hidden="true"></i>
                                            </button>

                                            <div id="userMenu" class="my-dropdown-menu" role="menu"
                                                aria-hidden="true">
                                                <a class="my-dropdown-item" href="{{ route('account.index') }}">
                                                    <i class="fa fa-user-circle" style="margin-right:6px"></i> My
                                                    Account
                                                </a>
                                                <div class="my-dropdown-divider" role="separator"></div>
                                                <a class="my-dropdown-item" href="#"
                                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    <i class="fa fa-sign-out-alt" style="margin-right:6px"></i> Logout
                                                </a>
                                            </div>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                            </form>
                                        </div>
                                    @else
                                        @if (request()->routeIs('login'))
                                            <a href="{{ route('register') }}" class="my-login-link">
                                                <p class="px-2 m-auto" style="color: white">
                                                    Register&nbsp;<i class="fa fa-user-plus"></i>
                                                </p>
                                            </a>
                                        @else
                                            <a href="{{ route('login') }}" class="my-login-link">
                                                <p class="px-2 m-auto" style="color: white">
                                                    Login&nbsp;<i class="fa fa-sign-in-alt"></i>
                                                </p>
                                            </a>
                                        @endif

                                    @endif

                                    <style>
                                        /* ---------- container & toggle ---------- */
                                        .my-dropdown {
                                            position: relative;
                                            display: inline-block;
                                        }

                                        .my-dropdown-toggle {
                                            background: transparent;
                                            border: none;
                                            color: #fff;
                                            cursor: pointer;
                                            padding: 6px 8px;
                                            display: inline-flex;
                                            align-items: center;
                                            gap: 8px;
                                            font: inherit;
                                        }

                                        /* chevron animation */
                                        .my-dropdown-icon {
                                            transition: transform 180ms ease;
                                        }

                                        /* ---------- menu (custom name avoids bootstrap collision) ---------- */
                                        .my-dropdown-menu {
                                            position: absolute;
                                            right: 0;
                                            top: calc(100% + 8px);
                                            min-width: 180px;
                                            background: rgb(255, 33, 67);
                                            border: 1px solid red;
                                            border-radius: 6px;
                                            box-shadow: 0 8px 20px red;
                                            transform-origin: top center;
                                            transform: translateY(-6px) scale(0.98);
                                            opacity: 0;
                                            pointer-events: none;
                                            transition: transform 180ms ease, opacity 180ms ease;
                                            z-index: 2100;
                                        }

                                        /* visible state */
                                        .my-dropdown.open .my-dropdown-menu {
                                            transform: translateY(0) scale(1);
                                            opacity: 1;
                                            pointer-events: auto;
                                        }

                                        /* rotate icon when open */
                                        .my-dropdown.open .my-dropdown-icon {
                                            transform: rotate(180deg);
                                        }

                                        /* menu items */
                                        .my-dropdown-item {
                                            display: block;
                                            padding: 10px 14px;
                                            color: #fff;
                                            text-decoration: none;
                                            font-size: 14px;
                                        }

                                        .my-dropdown-item:hover,
                                        .my-dropdown-item:focus {
                                            background: #495057;
                                            color: #fff;
                                            outline: none;
                                        }

                                        /* divider */
                                        .my-dropdown-divider {
                                            height: 1px;
                                            background: #495057;
                                            margin: 6px 0;
                                        }

                                        /* helpful: avoid parent overflow clipping */
                                        .my-dropdown {
                                            overflow: visible;
                                        }

                                        /* optional: small responsive tweak */
                                        @media (max-width: 480px) {
                                            .my-dropdown-menu {
                                                right: 0;
                                                left: 0;
                                                margin: 0 8px;
                                                width: auto;
                                            }
                                        }
                                    </style>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', () => {
                                            // Initialize all custom dropdowns (supports multiple)
                                            document.querySelectorAll('[data-dropdown]').forEach(drop => {
                                                const toggle = drop.querySelector('.my-dropdown-toggle');
                                                const menu = drop.querySelector('.my-dropdown-menu');

                                                if (!toggle || !menu) return;

                                                // toggle click
                                                toggle.addEventListener('click', (ev) => {
                                                    ev.stopPropagation();
                                                    const isOpen = drop.classList.toggle('open');
                                                    toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                                                    menu.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
                                                });

                                                // close when clicking an item (optional)
                                                menu.addEventListener('click', (ev) => {
                                                    // you may want to keep open for certain links; this closes by default
                                                    drop.classList.remove('open');
                                                    toggle.setAttribute('aria-expanded', 'false');
                                                    menu.setAttribute('aria-hidden', 'true');
                                                });
                                            });

                                            // close on outside click
                                            document.addEventListener('click', (ev) => {
                                                document.querySelectorAll('[data-dropdown].open').forEach(openDrop => {
                                                    if (!openDrop.contains(ev.target)) {
                                                        openDrop.classList.remove('open');
                                                        const togg = openDrop.querySelector('.my-dropdown-toggle');
                                                        const m = openDrop.querySelector('.my-dropdown-menu');
                                                        if (togg) togg.setAttribute('aria-expanded', 'false');
                                                        if (m) m.setAttribute('aria-hidden', 'true');
                                                    }
                                                });
                                            });

                                            // close on ESC
                                            document.addEventListener('keydown', (ev) => {
                                                if (ev.key === 'Escape') {
                                                    document.querySelectorAll('[data-dropdown].open').forEach(openDrop => {
                                                        openDrop.classList.remove('open');
                                                        const togg = openDrop.querySelector('.my-dropdown-toggle');
                                                        const m = openDrop.querySelector('.my-dropdown-menu');
                                                        if (togg) togg.setAttribute('aria-expanded', 'false');
                                                        if (m) m.setAttribute('aria-hidden', 'true');
                                                    });
                                                }
                                            });
                                        });
                                    </script>


                                </div>
                            </div>
                        </div>
                        <!-- Mobile Menu -->
                        <div class="col-12">
                            <div class="mobile_menu d-block d-md-none">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- Header End -->
    </header>


    @yield('main')

    @if (!(request()->is('login') || request()->is('register') || request()->is('account*')))
        <footer>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const icon = document.querySelector('.slicknav_icon');
                    icon.addEventListener('click', function() {
                        this.classList.toggle('active');
                    });
                });
            </script>
            <!-- Footer Start-->
            <div class="footer-main footer-bg">
                <div class="footer-area footer-padding">
                    <div class="container">
                        <div class="row d-flex justify-content-between">
                            <div class="col-xl-3 col-lg-3 col-md-5 col-sm-8">
                                <div class="single-footer-caption mb-50">
                                    <div class="single-footer-caption mb-30">
                                        <!-- logo -->
                                        <div class="footer-logo">
                                            <a href="index.html"><img src="assets/img/logo/logo2_footer.png"
                                                    alt=""></a>
                                        </div>
                                        <div class="footer-tittle">
                                            <div class="footer-pera">
                                                <p class="info1">Lorem ipsum dolor sit amet, nsectetur adipiscing
                                                    elit,
                                                    sed do eiusmod tempor incididunt ut labore.</p>
                                                <p class="info2">198 West 21th Street, Suite 721 New York,NY 10010</p>
                                                <p class="info2">Phone: +95 (0) 123 456 789 Cell: +95 (0) 123 456 789
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-5 col-sm-7">
                                <div class="single-footer-caption mb-50">
                                    <div class="footer-tittle">
                                        <h4>Popular post</h4>
                                    </div>
                                    <!-- Popular post -->
                                    <div class="whats-right-single mb-20">
                                        <div class="whats-right-img">
                                            <img src="assets/img/gallery/footer_post1.png" alt="">
                                        </div>
                                        <div class="whats-right-cap">
                                            <h4><a href="details.html">Scarlett’s disappointment at latest accolade</a>
                                            </h4>
                                            <p>Jhon | 2 hours ago</p>
                                        </div>
                                    </div>
                                    <!-- Popular post -->
                                    <div class="whats-right-single mb-20">
                                        <div class="whats-right-img">
                                            <img src="assets/img/gallery/footer_post2.png" alt="">
                                        </div>
                                        <div class="whats-right-cap">
                                            <h4><a href="details.html">Scarlett’s disappointment at latest accolade</a>
                                            </h4>
                                            <p>Jhon | 2 hours ago</p>
                                        </div>
                                    </div>
                                    <!-- Popular post -->
                                    <div class="whats-right-single mb-20">
                                        <div class="whats-right-img">
                                            <img src="assets/img/gallery/footer_post3.png" alt="">
                                        </div>
                                        <div class="whats-right-cap">
                                            <h4><a href="details.html">Scarlett’s disappointment at latest accolade</a>
                                            </h4>
                                            <p>Jhon | 2 hours ago</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-5 col-sm-7">
                                <div class="single-footer-caption mb-50">
                                    <div class="banner">
                                        <img src="assets/img/gallery/body_card4.png" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- footer-bottom aera -->
                <div class="footer-bottom-area footer-bg">
                    <div class="container">
                        <div class="footer-border">
                            <div class="row d-flex align-items-center">
                                <div class="col-xl-12 ">
                                    <div class="footer-copy-right text-center">
                                        <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                            Copyright &copy;
                                            <script>
                                                document.write(new Date().getFullYear());
                                            </script> All rights reserved
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End-->
        </footer>
    @endif

    <!-- JS here -->
    <!-- All JS Custom Plugins Link Here here -->
    {{-- <script src="{{ asset('assets/js/vendor/modernizr-3.5.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/gijgo.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/animated.headline.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.magnific-popup.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.sticky.js') }}"></script>
    <script src="{{ asset('assets/js/contact.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.form.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/mail-script.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script> --}}
    {{-- in use  --}}
    {{-- <script src="{{ asset('assets/js/vendor/jquery-1.12.4.min.js') }}"></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="{{ asset('assets/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slicknav.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/main.js') }}"></script> --}}




    <style>
        #toast-container {
            position: fixed;
            top: 20px;
            right: 0px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .toast {
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-width: 250px;
            max-width: 350px;
            padding: 12px 16px;
            border-radius: 8px;
            color: #fff;
            font-size: 14px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            animation: slideIn 0.3s ease;
        }

        .toast-success {
            background-color: #28a745;
            /* green */
        }

        .toast-error {
            background-color: green;
            /* red */
        }

        .toast button.toast-close {
            background: none;
            border: none;
            color: #fff;
            font-size: 16px;
            margin-left: 12px;
            cursor: pointer;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(100%);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>

    @if (session('success') || session('error'))
        <div id="toast-container">
            @if (session('success'))
                <div class="toast toast-success show">
                    <span>{{ session('success') }}</span>
                    <button class="toast-close">&times;</button>
                </div>
            @endif
            @if (session('error'))
                <div class="toast toast-error show">
                    <span>{{ session('error') }}</span>
                    <button class="toast-close">&times;</button>
                </div>
            @endif

        </div>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toasts = document.querySelectorAll(".toast");
            toasts.forEach(toast => {
                // Manual close
                toast.querySelector(".toast-close").addEventListener("click", () => {
                    toast.remove();
                });
            });
        });
    </script>
</body>

</html>
