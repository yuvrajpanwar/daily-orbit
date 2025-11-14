<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3405668939695709" crossorigin="anonymous"></script>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Daily Orbit</title>
    <meta name="description" content="Daily Orbit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/assets/img/favicon.ico') }}">
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
            padding: 20px 20px !important;
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
        .preloader {
            background-color: #f7f7f7;
            height: 100vh;
            width: 100vw;
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 999999;
            margin: 0 auto
        }

        .preloader .preloader-circle {
            width: 100px;
            height: 100px;
            position: relative;
            z-index: 10;
            border-radius: 50%;
        }

        .preloader .preloader-img {
            position: absolute;
            top: 50%;
            z-index: 200;
            left: 0;
            right: 0;
            margin: 0 auto;
            text-align: center;
            display: inline-block;
        }

        .preloader .preloader-img img {
            max-width: 55px
        }

        .preloader .pere-text strong {
            font-weight: 800;
            color: #dca73a;
            text-transform: uppercase
        }
        #scrollUp{
            text-decoration: none;
        }

        
    </style>


    <style>
        /* Container */
        .popular-posts-container {
            position: relative;
        }

        /* Shimmer Item */
        .shimmer-item {
            display: flex;
            gap: 15px;
            align-items: center;
            padding: 8px 0;
            animation: fadeIn 0.6s ease-out forwards;
            opacity: 0;
        }

        .shimmer-item:nth-child(1) { animation-delay: 0.1s; }
        .shimmer-item:nth-child(2) { animation-delay: 0.2s; }
        .shimmer-item:nth-child(3) { animation-delay: 0.3s; }

        /* Image Placeholder */
        .shimmer-img {
            width: 70px;
            height: 70px;
            border-radius: 10px;
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.8s ease-in-out infinite;
            position: relative;
            overflow: hidden;
        }

        .shimmer-img::after {
            content: '';
            position: absolute;
            top: 0; left: -150%;
            width: 50%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6), transparent);
            animation: shine 1.8s ease-in-out infinite;
        }

        /* Text Lines */
        .shimmer-line {
            height: 14px;
            border-radius: 7px;
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.8s ease-in-out infinite;
            margin: 6px 0;
        }

        .shimmer-line.title { 
            width: 85%; 
            height: 16px;
        }
        .shimmer-line.meta { 
            width: 60%; 
            height: 12px;
        }

        /* Animations */
        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        @keyframes shine {
            0% { left: -150%; }
            100% { left: 150%; }
        }

        @keyframes fadeIn {
            to { opacity: 1; }
        }

        /* Real Content Fade In */
        #popular-posts-content .whats-right-single {
            animation: fadeInContent 0.5s ease-out forwards;
            opacity: 0;
        }

        #popular-posts-content .whats-right-single:nth-child(1) { animation-delay: 0.1s; }
        #popular-posts-content .whats-right-single:nth-child(2) { animation-delay: 0.2s; }
        #popular-posts-content .whats-right-single:nth-child(3) { animation-delay: 0.3s; }

        @keyframes fadeInContent {
            to { opacity: 1; transform: translateY(0); }
            from { opacity: 0; transform: translateY(5px); }
        }

        /* Real Image */
        .whats-right-img img {
            width: 100px !important;
            height: 70px !important;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
        }

        .whats-right-img img:hover {
            transform: scale(1.05);
        }

        /* Typography */
        .whats-right-cap h4 {
            margin: 0;
            font-size: 14.5px;
            line-height: 1.4;
            font-weight: 600;
            color: #1a1a1a;
        }

        .whats-right-cap h4 a {
            color: inherit;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .whats-right-cap h4 a:hover {
            color: #ff4757;
        }

        .whats-right-cap p {
            margin: 4px 0 0;
            font-size: 12px;
            color: #666;
            font-weight: 500;
        }

        @media only screen and (max-width: 1199px){
            .btn.post-btn{
                background : #FFCCCC !important;
                border: 1px solid #ff2143 !important;
            }

        }

    </style>


    @stack('css')
</head>

<body>
    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader  d-flex align-items-center justify-content-center"
            style="height: 100vh;width:100vw;right:auto">
            <div class="preloader-inner position-relative">
                <img src="/assets/img/logo/logo-circle.png" height="100px" class="preloader-circle logo-spin-round"
                    style="border: none !important;">
            </div>
        </div>
    </div>
    <!-- Preloader End -->
    <header>
        <!-- Header Start -->
        <div class="header-area">
            <div class="main-header ">
                {{-- <div class="header-mid gray-bg p-0">
                    <div class="container">
                        <div class="row d-flex align-items-center">
                            <!-- Logo -->
                            <div class="col-xl-4 col-lg-4 col-md-4 d-none d-md-block">
                                <div class="logo">
                                    <a href="/" style="display: flex;height:60px;width:fit-content;">
                                        <img src="/assets/img/logo/logo-text.png" alt="Daily Orbit Logo">
                                        <img src="/assets/img/logo/logo-circle.png" class="logo-spin-round"
                                            alt="Daily Orbit Logo">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="header-bottom header-sticky">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-xl-11 col-lg-11 col-md-11 header-flex">
                                <!-- sticky -->
                                <div class="sticky-logo my-1">
                                    <div class="d-flex">
                                        <div class="my-dropdown" data-dropdown
                                            style="
                                                    margin-top: auto;
                                                    margin-bottom: auto;
                                                    margin-right: 20px;
                                                    padding: 1rem;
                                                    color: white;
                                                    border: 1px solid white;
                                                    border-radius: 10px;
                                                    width: 40px;
                                                    height: 40px;
                                                    justify-content: center;
                                                    display: flex;
                                                    @if (Auth::check() && Auth::user()->avatar) background: url('{{ Auth::user()->avatar }}');
                                                    background-size: cover;
                                                    background-position: center; @endif
                                            ">
                                            {{-- if user is log in and have avatar then show avatar image else show user icon --}}
                                            @if (!Auth::check() || (Auth::check() && !Auth::user()->avatar))
                                                <div class="my-dropdown-toggle p-0 m-0">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                            @else
                                                <div class="my-dropdown-toggle w-100 h-100">

                                                </div>
                                            @endif





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
                                        <a href="/" style="display: flex;height:50px;width:fit-content;">
                                            <img src="/assets/img/logo/logo-text-white.png" alt="Daily Orbit Logo">
                                            <img src="/assets/img/logo/logo-circle-white.png" class="logo-spin-round"
                                                style="padding:.7rem 0;" alt="Daily Orbit Logo">
                                        </a>
                                    </div>
                                </div>
                                <!-- Main-menu -->
                                <div class="main-menu d-none d-md-block">
                                    <nav style="display: flex;width:100%;flex-wrap:wrap;">
                                        <div class="logo d-flex justify-content-center align-items-center">
                                            <a href="/" style="display: flex;height:45px;width:fit-content;margin-right:1rem;">
                                                <img src="/assets/img/logo/logo-text-white.png" alt="Daily Orbit Logo">
                                                <img src="/assets/img/logo/logo-circle-white.png" class="logo-spin-round"
                                                    alt="Daily Orbit Logo">
                                            </a>
                                        </div>
                                        <ul id="navigation">
                                            <li><a href="/">Home</a></li>
                                            <li><a href="/post/औली-में-स्कीइंग-का-रोमांच-बर्फीले-ढलानों-पर-उड़ान">Must Read</a></li>
                                            <li><a href="#">Categories &nbsp;<i class="fa fa-chevron-down not-for-mobile"></i> </a>
                                                <ul class="submenu">
                                                    @foreach($categories as $category)
                                                        <li><a href="{{ route('category.show', ['name' => $category->name]) }}">{{ $category->name }}</a></li>  
                                                    @endforeach
                                                    {{-- cont of categories  --}}
                                                    {{-- {{dd($categories->count())}} --}}
                                                </ul>
                                            </li>
                                            <li><a href="{{route('about')}}">About</a></li>
                                            <li><a href="{{route('contact-us')}}">Contact</a></li>
                                            
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="col-xl-1 col-lg-1 col-md-1 not-for-mobile">
                                <div class="header-right f-right d-lg-block"
                                    style="border: 1px solid white;border-radius:5px;">
                                    @if (Auth::check())
                                        <div class="my-dropdown" data-dropdown>
                                            <button type="button" class="my-dropdown-toggle" aria-haspopup="true"
                                                aria-expanded="false" aria-controls="userMenu">

                                                {{-- if user is log in and have avatar then show avatar image else show user icon --}}
                                                @if (Auth::user()->avatar)
                                                    <img src="{{ Auth::user()->avatar }}" alt="User Avatar"
                                                        style="width:32px;height:32px;border-radius:50%;margin-right:6px;object-fit:cover">
                                                @else
                                                    <i class="fa fa-user" aria-hidden="true"
                                                        style="margin-right:6px"></i>
                                                @endif

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
                    const slicknav_btn = document.querySelector('.slicknav_btn');
                    slicknav_btn.addEventListener('click', function() {
                        icon.classList.toggle('active');
                    });
                });
            </script>
            <!-- Footer Start-->
            <div class="footer-main footer-bg">
                <div class="footer-area footer-padding">
                    <div class="container">
                        <div class="row d-flex justify-content-start gap-4">
                            <div class="col-xl-3 col-lg-3 col-md-5 col-sm-8">
                                <div class="single-footer-caption mb-50">
                                    <div class="single-footer-caption mb-30">
                                        <!-- logo -->
                                        <div class="footer-tittle">
                                                <h4>Daily Orbit</h4>
                                            </div>
                                        <div class="footer-tittle">
                                            <div class="footer-pera text-white">
                                                <h5 style="white-space: nowrap; font-weight:bold">Official Contact Information</h4>
                                                <ul class="contact-list">
                                                    <li><strong>Email:</strong> <a href="mailto:info@dailyorbit.in">info@dailyorbit.in</a></li>
                                                    <li><strong>Phone:</strong> <a href="tel:+918126935280">+91 8126935280</a></li>
                                                    <li><strong>Address:</strong><br>
                                                        1202 , Rishivihar <br>
                                                        Dehradun , Uttarakhand - 248001<br>
                                                        India
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-5 col-sm-7">
                                
                                {{-- <div class="single-footer-caption mb-50">
                                    <div class="footer-tittle">
                                        <h4>Popular post</h4>
                                    </div>
                                    <!-- Popular post -->
                                    <div class="whats-right-single mb-20">
                                        <div class="whats-right-img">
                                            <img src="/assets/img/gallery/footer_post1.png" alt="">
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
                                            <img src="/assets/img/gallery/footer_post2.png" alt="">
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
                                            <img src="/assets/img/gallery/footer_post3.png" alt="">
                                        </div>
                                        <div class="whats-right-cap">
                                            <h4><a href="details.html">Scarlett’s disappointment at latest accolade</a>
                                            </h4>
                                            <p>Jhon | 2 hours ago</p>
                                        </div>
                                    </div>
                                </div> --}}


                                <div class="single-footer-caption mb-50 popular-posts-container">
                                    <div class="footer-tittle">
                                        <h4>Popular Posts</h4>
                                    </div>

                                    <!-- Shimmer Loading -->
                                    <div id="popular-posts-loading">
                                        @for($i = 0; $i < 3; $i++)
                                            <div class="shimmer-item">
                                                <div class="shimmer-img"></div>
                                                <div style="flex: 1;">
                                                    <div class="shimmer-line title"></div>
                                                    <div class="shimmer-line meta"></div>
                                                </div>
                                            </div>
                                        @endfor
                                    </div>

                                    <!-- Real Content -->
                                    <div id="popular-posts-content" style="display: none;"></div>
                                </div>


                            </div>
                            {{-- <div class="col-xl-3 col-lg-3 col-md-5 col-sm-7">
                                <div class="single-footer-caption mb-50">
                                    <div class="banner">
                                        <img src="/assets/img/gallery/body_card4.png" alt="">
                                    </div>
                                </div>
                            </div> --}}
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
                                        <p>Copyright &copy;
                                            <script>
                                                document.write(new Date().getFullYear());
                                            </script> All rights reserved <br> <a href="{{route('terms-and-conditions')}}" ">Terms & Conditions</a> | <a href="{{route('privacy-policy')}}" ">Privacy Policy</a>
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="{{ asset('assets/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slicknav.min.js') }}"></script>




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
            color: black;
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
    <div id="toast-container">
        @if (session('success') || session('error'))
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
        @endif
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toasts = document.querySelectorAll(".toast");
            toasts.forEach(toast => {
                // Manual close
                toast.querySelector(".toast-close").addEventListener("click", () => {
                    toast.remove();
                });
            });
            $('#preloader-active').css('display', 'none');
        });
        /* 1. Proloder */
        $(window).on('load', function() {
            
        });
    </script>

    <script>
$(document).ready(function() {
    $.ajax({
        url: '{{ route("popular.posts") }}',
        method: 'GET',
        cache: true,
        success: function(posts) {
            let html = '';
            posts.forEach(function(post, index) {
                html += `
                    <div class="whats-right-single mb-20">
                        <div class="whats-right-img">
                            <img src="${post.image}" alt="${post.title}" loading="lazy">
                        </div>
                        <div class="whats-right-cap">
                            <h4><a href="/post/${post.slug}">${post.title}</a></h4>
                            <p>${post.author_name} | ${post.time_ago}</p>
                        </div>
                    </div>
                `;
            });

            $('#popular-posts-loading').fadeOut(400, function() {
                $('#popular-posts-content').html(html).fadeIn(500);
            });
        },
        error: function() {
            $('#popular-posts-loading').html('<p class="text-center text-muted small py-3">Failed to load posts.</p>');
        }
    });
});
</script>
    @vite(['resources/js/app.js'])
    @stack('scripts')

    <script>
        //if any of the images in the page is not found then replace it with /assets/img/default-image.png
        document.addEventListener("DOMContentLoaded", function () {
            const defaultSrc = "/assets/img/default-image.png";

            function onError() {
                // prevent infinite loop if default is missing or already set
                if (this.dataset.replaced === "true" || this.src === defaultSrc) return;
                this.dataset.replaced = "true";
                this.src = defaultSrc;
                console.log("Image not found. Replaced with default image.", this);
            }

            function handleImg(img) {
                if (!img) return;

                // If image element already finished loading and is broken, replace immediately
                if (img.complete) {
                if (img.naturalWidth === 0 && img.src !== defaultSrc) {
                    img.dataset.replaced = "true";
                    img.src = defaultSrc;
                    console.log("Found broken image (after load). Replaced:", img);
                }
                // even if successful nothing to do
                } else {
                // attach error listener for future failure
                img.addEventListener("error", onError, { once: true });
                // also set a fallback check after a short delay (optional)
                setTimeout(() => {
                    if (img.naturalWidth === 0 && img.src !== defaultSrc) {
                    img.dataset.replaced = "true";
                    img.src = defaultSrc;
                    console.log("Timeout check: replaced broken image:", img);
                    }
                }, 3000);
                }
            }

            // initial pass
            Array.from(document.getElementsByTagName("img")).forEach(handleImg);

            // watch for images added later (appended by JS)
            const mo = new MutationObserver((mutations) => {
                for (const m of mutations) {
                for (const node of m.addedNodes) {
                    if (node.nodeType !== 1) continue; // skip text nodes
                    if (node.tagName === "IMG") handleImg(node);
                    else node.querySelectorAll && node.querySelectorAll("img").forEach(handleImg);
                }
                }
            });

            mo.observe(document.body, { childList: true, subtree: true });
        });

    </script>
</body>

</html>
