<!doctype html>
<html class="no-js" lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        
        
        <!-- 1. Proper Title (50–60 chars) -->
        <title>@yield('title', 'Daily Orbit - Latest Trending News, Breaking Stories & Updates')</title>
        
        <!-- 2. Meta Description (150–160 chars) -->
        <meta name="description" 
              content="@yield('meta_description', 'Daily Orbit brings you the latest trending news, breaking stories, politics, entertainment, sports and viral updates from India and around the world.')">
        
        <!-- 3. Viewport (you have it – good) -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="viewport" content="width=device-width, initial-scale=1,interactive-widget=resizes-visual">
        
        <!-- 4. Robots – don’t block anything -->
        <meta name="robots" content="index, follow">
    
        <!-- 5. Canonical URL (prevents duplicate issues) -->
        <link rel="canonical" href="{{ url()->current() }}">
    
        <!-- 6. Favicon (you have it – good) -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/assets/img/favicon.ico') }}">
    
        <!-- 7. Open Graph / Social Tags (huge for sharing & indirect SEO) -->
        <meta property="og:title" content="@yield('title', 'Daily Orbit - Latest Trending News')">
        <meta property="og:description" content="@yield('meta_description', 'Daily Orbit brings you the latest trending news...')">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image" content="{{ asset('assets/img/og-image.jpg') }}"> <!-- Create this 1200×630 image -->
        <meta property="og:site_name" content="Daily Orbit">
        <meta name="twitter:card" content="summary_large_image">
    
        <!-- Organization + WebSite Schema -->
        <script type="application/ld+json">
            {
            "@context": "https://schema.org",
            "@graph": [
                {
                "@type": "Organization",
                "name": "Daily Orbit",
                "url": "https://dailyorbit.in",
                "logo": "{{ asset('assets/img/logo/logo-circle.png') }}",
                "sameAs": [
                    "https://www.facebook.com/dailyorbit",
                    "https://twitter.com/dailyorbit",
                    "https://www.instagram.com/dailyorbit"
                ],
                "contactPoint": {
                    "@type": "ContactPoint",
                    "email": "info@dailyorbit.in",
                    "contactType": "Customer Support"
                }
                },
                {
                "@type": "WebSite",
                "url": "https://dailyorbit.in",
                "name": "Daily Orbit",
                "potentialAction": {
                    "@type": "SearchAction",
                    "target": "https://dailyorbit.in/search?q={search_term_string}",
                    "query-input": "required name=search_term_string"
                }
                }
            ]
            }
            </script>
    
        <!-- Google Adsense (keep it) -->
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3405668939695709"
                crossorigin="anonymous"></script>
    
        <!-- CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/global.min.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css">
        @stack('css')


        
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Syne:wght@700;800&display=swap" rel="stylesheet">

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
                                                    <a class="my-dropdown-item"
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
                                            <li><a>Categories &nbsp;<i class="fa fa-chevron-down not-for-mobile"></i> </a>
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
                                            @if (Auth::check())
                                                {{-- logout --}}
                                                <li class="not-for-dasktop" style="border-top: 1px solid black;color:black">
                                                    <a style="display:flex;justify-content:space-between;align-items:center;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                        Logout <i class="fa fa-sign-out-alt"></i>
                                                    </a>
                                                </li>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                </form>
                                            @else
                                                {{-- login --}}
                                                <li class="not-for-dasktop" style="border-top: 1px solid black;">
                                                        <a style="display:flex;justify-content:space-between;align-items:center;" href="{{ route('login') }}">Login / Register <i class="fa fa-sign-in-alt"></i></a>
                                                </li>
                                            @endif
                                            
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

                                                <span class="my-user-name" style="white-space: nowrap;">
                                                    {{ strlen(Auth::user()->name) > 10 ? substr(Auth::user()->name, 0, 10) . '...' : Auth::user()->name }}
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
                                                <a class="my-dropdown-item" style="color:white"
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
                                                    <li><strong>Phone:</strong> <a href="tel:+918126935236">+918126935236</a></li>
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
    {{-- <script src="{{ asset('assets/js/jquery.scrollUp.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slicknav.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $('#preloader-active').css('display', 'none');
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
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            if (window.innerWidth >= 768) {
                document.querySelectorAll('.not-for-dasktop').forEach(el => el.remove());
            }
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
                                    <a href="/post/${post.slug}">
                                        <img src="${post.image}" alt="${post.title}" loading="lazy">
                                    </a>
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
    <script>
        document.addEventListener("DOMContentLoaded", function () {
        
            // Laravel validation errors ($errors)
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    iziToast.error({
                        message: @json($error),
                        position: 'topRight',
                        timeout: 10000
                    });
                @endforeach
            @endif
        
            // Session error (single message)
            @if (session('error'))
                iziToast.error({
                    title: 'Error',
                    message: @json(session('error')),
                    position: 'topRight',
                    timeout: 10000
                });
            @endif
        
            // Flash success
            @if (session('success'))
                iziToast.success({
                    title: 'Success',
                    message: @json(session('success')),
                    position: 'topRight',
                    timeout: 10000
                });
            @endif
        
            // Flash warning
            @if (session('warning'))
                iziToast.warning({
                    title: 'Warning',
                    message: @json(session('warning')),
                    position: 'topRight',
                    timeout: 10000
                });
            @endif
        
        });
    </script>

















 <style>
    /* ──────────────────────────────────────────────
       RESET & BASE
    ────────────────────────────────────────────── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'DM Sans', sans-serif;
      background: #f0f2f5;
      min-height: 100vh;
    }

    /* ──────────────────────────────────────────────
       CSS VARIABLES
    ────────────────────────────────────────────── */
    :root {
      --uv-primary:       #0f172a;
      --uv-accent:        #6366f1;
      --uv-accent-light:  #818cf8;
      --uv-accent-glow:   rgba(99,102,241,0.25);
      --uv-surface:       #ffffff;
      --uv-surface-2:     #f8fafc;
      --uv-border:        #e2e8f0;
      --uv-text:          #1e293b;
      --uv-text-muted:    #64748b;
      --uv-user-bubble:   #6366f1;
      --uv-ai-bubble:     #f1f5f9;
      --uv-radius-lg:     18px;
      --uv-radius-sm:     10px;
      --uv-shadow:        0 20px 60px rgba(0,0,0,0.15), 0 4px 16px rgba(0,0,0,0.08);
      --uv-shadow-fab:    0 8px 32px rgba(99,102,241,0.45), 0 2px 8px rgba(0,0,0,0.15);
      --widget-width:     380px;
      --widget-height:    580px;
    }

    /* ──────────────────────────────────────────────
       FLOATING ACTION BUTTON
    ────────────────────────────────────────────── */
    #uv-fab {
      position: fixed;
      bottom: 28px;
      right: 28px;
      width: 62px;
      height: 62px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--uv-accent) 0%, #4f46e5 100%);
      box-shadow: var(--uv-shadow-fab);
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 9998;
      border: none;
      outline: none;
      transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.3s ease;
    }

    #uv-fab:hover {
      transform: scale(1.1);
      box-shadow: 0 12px 40px rgba(99,102,241,0.55), 0 2px 8px rgba(0,0,0,0.2);
    }

    #uv-fab:active { transform: scale(0.95); }

    #uv-fab img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid rgba(255,255,255,0.6);
      pointer-events: none;
    }

    /* Pulse ring */
    #uv-fab::before {
      content: '';
      position: absolute;
      inset: -4px;
      border-radius: 50%;
      border: 2px solid var(--uv-accent);
      opacity: 0;
      animation: uv-pulse 2.5s ease-out infinite;
    }

    @keyframes uv-pulse {
      0%   { opacity: 0.7; transform: scale(1); }
      100% { opacity: 0;   transform: scale(1.5); }
    }

    /* ──────────────────────────────────────────────
       CHAT WINDOW
    ────────────────────────────────────────────── */
    #uv-chat-window {
      position: fixed;
      bottom: 10px;
      right: 10px;
      width: var(--widget-width);
      height: var(--widget-height);
      background: var(--uv-surface);
      border-radius: 24px;
      box-shadow: var(--uv-shadow);
      display: flex;
      flex-direction: column;
      overflow: hidden;
      z-index: 9999;
      border: 1px solid var(--uv-border);

      opacity: 0;
      transform: translateY(20px) scale(0.95);
      transform-origin: bottom right;
      pointer-events: none;
      transition:
        opacity 0.35s cubic-bezier(0.4,0,0.2,1),
        transform 0.35s cubic-bezier(0.34,1.56,0.64,1);
    }

    #uv-chat-window.uv-open {
      opacity: 1;
      transform: translateY(0) scale(1);
      pointer-events: all;
    }

    /* ──────────────────────────────────────────────
       HEADER
    ────────────────────────────────────────────── */
    #uv-header {
      background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 60%, #312e81 100%);
      padding: 18px 20px;
      display: flex;
      align-items: center;
      gap: 12px;
      flex-shrink: 0;
      position: relative;
      overflow: hidden;
    }

    #uv-header::after {
      content: '';
      position: absolute;
      bottom: 0; left: 0; right: 0;
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(99,102,241,0.6), transparent);
    }

    #uv-avatar-wrap {
      position: relative;
      flex-shrink: 0;
    }

    #uv-header-avatar {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      object-fit: cover;
      border: 2.5px solid rgba(255,255,255,0.2);
      display: block;
    }

    #uv-avatar-wrap::after {
      content: '';
      position: absolute;
      bottom: 1px; right: 1px;
      width: 11px; height: 11px;
      background: #22c55e;
      border-radius: 50%;
      border: 2px solid #0f172a;
    }

    #uv-header-info { flex: 1; min-width: 0; }

    #uv-header-name {
      font-size: 17px;
      font-weight: 800;
      color: #ffffff;
      letter-spacing: 0.02em;
      line-height: 1.2;
    }

    #uv-header-status {
      font-size: 12px;
      color: rgba(255,255,255,0.55);
      margin-top: 2px;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    #uv-header-status span {
      width: 6px; height: 6px;
      background: #22c55e;
      border-radius: 50%;
      display: inline-block;
      animation: uv-blink 2s ease-in-out infinite;
    }

    @keyframes uv-blink {
      0%, 100% { opacity: 1; }
      50%       { opacity: 0.3; }
    }

    /* Header action buttons (refresh + close) */
    .uv-header-btn {
      background: rgba(255,255,255,0.1);
      border: none;
      color: rgba(255,255,255,0.7);
      cursor: pointer;
      width: 34px; height: 34px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      transition: background 0.2s, color 0.2s, transform 0.2s;
    }

    .uv-header-btn:hover {
      background: rgba(255,255,255,0.2);
      color: #ffffff;
    }

    #uv-refresh-btn:hover { transform: rotate(180deg); }
    #uv-close-btn:hover   { transform: rotate(90deg); }

    .uv-header-btn svg { display: block; }

    /* ──────────────────────────────────────────────
       CONFIRM BANNER (new chat confirmation)
    ────────────────────────────────────────────── */
    #uv-confirm-bar {
      display: none;
      align-items: center;
      justify-content: space-between;
      gap: 10px;
      padding: 10px 16px;
      background: #fefce8;
      border-bottom: 1px solid #fde68a;
      font-size: 13px;
      color: #78350f;
      flex-shrink: 0;
      animation: uv-slide-down 0.25s ease both;
    }

    #uv-confirm-bar.uv-visible { display: flex; }

    @keyframes uv-slide-down {
      from { opacity: 0; transform: translateY(-8px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    #uv-confirm-bar .uv-confirm-text {
      flex: 1;
      font-weight: 600;
    }

    #uv-confirm-bar .uv-confirm-text small {
      display: block;
      font-weight: 400;
      font-size: 11.5px;
      color: #92400e;
      margin-top: 1px;
    }

    .uv-confirm-actions { display: flex; gap: 6px; }

    .uv-confirm-btn {
      padding: 5px 13px;
      border-radius: 20px;
      border: none;
      cursor: pointer;
      font-size: 12.5px;
      font-weight: 600;
      font-family: 'DM Sans', sans-serif;
      transition: transform 0.15s, opacity 0.15s;
    }

    .uv-confirm-btn:active { transform: scale(0.95); }

    #uv-confirm-yes {
      background: #ef4444;
      color: #fff;
    }

    #uv-confirm-yes:hover { opacity: 0.88; }

    #uv-confirm-no {
      background: rgba(120,53,15,0.12);
      color: #78350f;
    }

    #uv-confirm-no:hover { background: rgba(120,53,15,0.2); }

    /* ──────────────────────────────────────────────
       MESSAGES AREA
    ────────────────────────────────────────────── */
    #uv-messages {
      flex: 1;
      overflow-y: auto;
      padding: 20px 16px;
      display: flex;
      flex-direction: column;
      gap: 12px;
      background: var(--uv-surface-2);
      scroll-behavior: smooth;
    }

    #uv-messages::-webkit-scrollbar { width: 4px; }
    #uv-messages::-webkit-scrollbar-track { background: transparent; }
    #uv-messages::-webkit-scrollbar-thumb {
      background: var(--uv-border);
      border-radius: 4px;
    }

    .uv-msg-row {
      display: flex;
      align-items: flex-end;
      gap: 8px;
      animation: uv-msg-in 0.3s cubic-bezier(0.34,1.56,0.64,1) both;
    }

    @keyframes uv-msg-in {
      from { opacity: 0; transform: translateY(12px) scale(0.96); }
      to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    .uv-msg-row.uv-user { flex-direction: row-reverse; }

    .uv-row-avatar {
      width: 30px; height: 30px;
      border-radius: 50%;
      object-fit: cover;
      flex-shrink: 0;
      border: 1.5px solid var(--uv-border);
    }

    .uv-msg-row.uv-user .uv-row-avatar { display: none; }

    .uv-bubble {
      max-width: 72%;
      padding: 11px 15px;
      border-radius: var(--uv-radius-lg);
      font-size: 14.5px;
      line-height: 1.55;
      word-break: break-word;
      position: relative;
    }

    .uv-msg-row.uv-ai .uv-bubble {
      background: var(--uv-surface);
      color: var(--uv-text);
      border-bottom-left-radius: 4px;
      box-shadow: 0 1px 4px rgba(0,0,0,0.06);
      border: 1px solid var(--uv-border);
    }

    .uv-msg-row.uv-user .uv-bubble {
      background: linear-gradient(135deg, var(--uv-accent) 0%, #4f46e5 100%);
      color: #ffffff;
      border-bottom-right-radius: 4px;
      box-shadow: 0 4px 12px rgba(99,102,241,0.3);
    }

    .uv-bubble-time {
      display: block;
      font-size: 10.5px;
      margin-top: 5px;
      opacity: 0.55;
      text-align: right;
    }

    .uv-msg-row.uv-ai .uv-bubble-time { text-align: left; }

    /* Restored messages (no bounce animation) */
    .uv-msg-row.uv-restored {
      animation: uv-msg-fade 0.25s ease both;
    }

    @keyframes uv-msg-fade {
      from { opacity: 0; }
      to   { opacity: 1; }
    }

    /* History divider */
    .uv-history-divider {
      display: flex;
      align-items: center;
      gap: 10px;
      margin: 4px 0 8px;
      animation: uv-msg-fade 0.3s ease both;
    }

    .uv-history-divider::before,
    .uv-history-divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--uv-border);
    }

    .uv-history-divider span {
      font-size: 11px;
      color: var(--uv-text-muted);
      white-space: nowrap;
      font-weight: 500;
    }

    /* ── Typing indicator ── */
    #uv-typing-row {
      display: none;
      align-items: flex-end;
      gap: 8px;
      animation: uv-msg-in 0.3s ease both;
    }

    #uv-typing-row.uv-visible { display: flex; }

    .uv-typing-bubble {
      background: var(--uv-surface);
      border: 1px solid var(--uv-border);
      border-radius: var(--uv-radius-lg);
      border-bottom-left-radius: 4px;
      padding: 13px 18px;
      display: flex;
      gap: 5px;
      align-items: center;
      box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    }

    .uv-typing-dot {
      width: 7px; height: 7px;
      border-radius: 50%;
      background: var(--uv-accent-light);
      animation: uv-dot-bounce 1.2s ease-in-out infinite;
    }

    .uv-typing-dot:nth-child(2) { animation-delay: 0.18s; }
    .uv-typing-dot:nth-child(3) { animation-delay: 0.36s; }

    @keyframes uv-dot-bounce {
      0%, 60%, 100% { transform: translateY(0);  opacity: 0.5; }
      30%            { transform: translateY(-6px); opacity: 1;   }
    }

    /* ──────────────────────────────────────────────
       INPUT AREA
    ────────────────────────────────────────────── */
    #uv-input-area {
      padding: 14px 16px;
      background: var(--uv-surface);
      border-top: 1px solid var(--uv-border);
      display: flex;
      align-items: center;
      gap: 10px;
      flex-shrink: 0;
    }

    #uv-input {
      flex: 1;
      border: 1.5px solid var(--uv-border);
      border-radius: 50px;
      padding: 11px 18px;
      font-family: 'DM Sans', sans-serif;
      font-size: 14px;
      color: var(--uv-text);
      background: var(--uv-surface-2);
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s;
      resize: none;
    }

    #uv-input::placeholder { color: var(--uv-text-muted); }

    #uv-input:focus {
      border-color: var(--uv-accent);
      box-shadow: 0 0 0 3px var(--uv-accent-glow);
      background: #ffffff;
    }

    #uv-send-btn {
      width: 44px; height: 44px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--uv-accent) 0%, #4f46e5 100%);
      border: none;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      transition: transform 0.2s, box-shadow 0.2s, opacity 0.2s;
      box-shadow: 0 4px 12px rgba(99,102,241,0.35);
    }

    #uv-send-btn:hover:not(:disabled) {
      transform: scale(1.08);
      box-shadow: 0 6px 16px rgba(99,102,241,0.45);
    }

    #uv-send-btn:active:not(:disabled) { transform: scale(0.94); }

    #uv-send-btn:disabled {
      opacity: 0.45;
      cursor: not-allowed;
      box-shadow: none;
    }

    #uv-send-btn svg { display: block; }

    /* ──────────────────────────────────────────────
       POWERED-BY FOOTER
    ────────────────────────────────────────────── */
    #uv-footer {
      text-align: center;
      font-size: 10.5px;
      color: var(--uv-text-muted);
      padding: 7px 0 9px;
      background: var(--uv-surface);
      border-top: 1px solid var(--uv-border);
      letter-spacing: 0.01em;
      flex-shrink: 0;
    }

    #uv-footer strong { color: var(--uv-accent); }

    /* ──────────────────────────────────────────────
       MOBILE RESPONSIVE
    ────────────────────────────────────────────── */
    @media (max-width: 480px) {
      :root {
        --widget-width: 100vw;
        /* --widget-height: 100dvh; */
      }

      #uv-chat-window {
        bottom: 0; right: 0;
        left: 0;
        border-radius: 0;
        border: none;
        transform-origin: bottom center;
        position: fixed;       /* keep fixed */
        /* height set dynamically by JS */
      }

      #uv-fab {
        bottom: 20px;
        right: 20px;
      }
    }
  </style>


<!-- FAB -->
{{-- <button id="uv-fab" aria-label="Open UV chat" title="Chat with UV">
  <img
    src="{{ asset('assets/img/uv.jpg') }}"
    alt="UV"
    onerror="this.style.display='none'; this.parentElement.innerHTML += '<svg width=\'28\' height=\'28\' fill=\'none\' viewBox=\'0 0 24 24\'><path fill=\'%23fff\' d=\'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z\'/></svg>'"
  />
</button> --}}

<!-- Chat Window -->
<div id="uv-chat-window" role="dialog" aria-label="UV Chat" aria-modal="true">

  <!-- Header -->
  <div id="uv-header">
    <div id="uv-avatar-wrap">
      <img id="uv-header-avatar" src="{{ asset('assets/img/uv.jpg') }}" alt="UV Avatar" />
    </div>
    <div id="uv-header-info">
      <div id="uv-header-name">UV</div>
      <div id="uv-header-status">Online <span></span></div>
    </div>

    <!-- Refresh button (left of close) -->
    <button id="uv-refresh-btn" class="uv-header-btn" aria-label="New chat" title="Start new chat">
      <svg width="16" height="16" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
              d="M1 4v6h6M23 20v-6h-6"/>
        <path stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"
              d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4-4.64 4.36A9 9 0 0 1 3.51 15"/>
      </svg>
    </button>

    <!-- Close button -->
    <button id="uv-close-btn" class="uv-header-btn" aria-label="Close chat">
      <svg width="16" height="16" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-width="2.2" stroke-linecap="round" d="M18 6 6 18M6 6l12 12"/>
      </svg>
    </button>
  </div>

  <!-- Confirm bar (hidden by default, shown on refresh click) -->
  <div id="uv-confirm-bar" role="alert">
    <div class="uv-confirm-text">
      Start a new chat?
      <small>Current conversation will be cleared.</small>
    </div>
    <div class="uv-confirm-actions">
      <button class="uv-confirm-btn" id="uv-confirm-no">Cancel</button>
      <button class="uv-confirm-btn" id="uv-confirm-yes">Yes, reset</button>
    </div>
  </div>

  <!-- Messages -->
  <div id="uv-messages" role="log" aria-live="polite" aria-label="Chat messages">
    <!-- Typing indicator (always last child via JS) -->
    <div id="uv-typing-row">
      <img class="uv-row-avatar" src="{{ asset('assets/img/logo/logo-circle.png') }}" alt="UV" />
      <div class="uv-typing-bubble">
        <div class="uv-typing-dot"></div>
        <div class="uv-typing-dot"></div>
        <div class="uv-typing-dot"></div>
      </div>
    </div>
  </div>

  <!-- Input Area -->
  <div id="uv-input-area">
    <input
      type="text"
      id="uv-input"
      placeholder="Message UV…"
      autocomplete="off"
      maxlength="1000"
      aria-label="Type a message"
    />
    <button id="uv-send-btn" aria-label="Send message" disabled>
      <svg width="20" height="20" fill="none" viewBox="0 0 24 24">
        <path fill="#fff" d="M2.01 21 23 12 2.01 3 2 10l15 2-15 2z"/>
      </svg>
    </button>
  </div>

  <!-- Footer -->
  <div id="uv-footer">
    Ask anything about <strong>Yuvraj</strong>
  </div>

</div>


<!-- ══════════════════════════════════════
     JAVASCRIPT
══════════════════════════════════════ -->
<script>
(function () {
  'use strict';

  // ── DOM refs ──────────────────────────────────────────────
  const fab         = document.getElementById('uv-fab');
  const chatWindow  = document.getElementById('uv-chat-window');
  const closeBtn    = document.getElementById('uv-close-btn');
  const refreshBtn  = document.getElementById('uv-refresh-btn');
  const confirmBar  = document.getElementById('uv-confirm-bar');
  const confirmYes  = document.getElementById('uv-confirm-yes');
  const confirmNo   = document.getElementById('uv-confirm-no');
  const messagesEl  = document.getElementById('uv-messages');
  const inputEl     = document.getElementById('uv-input');
  const sendBtn     = document.getElementById('uv-send-btn');
  const typingRow   = document.getElementById('uv-typing-row');

  // ── Config ────────────────────────────────────────────────
  const ENDPOINT         = 'https://dailyorbit.in/chatbot/message';
  const HISTORY_ENDPOINT = 'https://dailyorbit.in/chatbot/history';
  const RESET_ENDPOINT   = 'https://dailyorbit.in/chatbot/reset';
  const AI_AVATAR        = "/portfolio/assets/img/uv.jpg";
  const GREETING         = "Heyy! mera naam hai UV 😎 \ntumhara naam kya hai?";
  const CSRF_TOKEN       = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

  // ── State ─────────────────────────────────────────────────
  let isOpen        = false;
  let isWaiting     = false;
  let greetingDone  = false;
  let confirmActive = false;
  let sessionToken  = localStorage.getItem('uv_chat_session') ?? null;

  // ── Helpers ───────────────────────────────────────────────
  function getTime() {
    return new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
  }

  function formatTime(isoString) {
    if (!isoString) return getTime();
    try {
      return new Date(isoString).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    } catch {
      return getTime();
    }
  }

  function scrollToBottom(instant = false) {
    messagesEl.appendChild(typingRow);
    if (instant) {
      messagesEl.style.scrollBehavior = 'auto';
      messagesEl.scrollTop = messagesEl.scrollHeight;
      messagesEl.style.scrollBehavior = '';
    } else {
      messagesEl.scrollTop = messagesEl.scrollHeight;
    }
  }

  /**
   * @param {'ai'|'user'} who
   * @param {string} text   — may contain HTML (links from server)
   * @param {string} time   — formatted time string
   * @param {boolean} restored — if true, use fade-in instead of bounce
   */
  function appendMessage(who, text, time = null, restored = false) {
    const row = document.createElement('div');
    row.className = `uv-msg-row uv-${who}${restored ? ' uv-restored' : ''}`;

    const avatarHTML = who === 'ai'
      ? `<img class="uv-row-avatar" src="${AI_AVATAR}" alt="UV" />`
      : '';

    const displayTime = time ?? getTime();

    // Server replies may contain anchor tags — render as HTML.
    // User messages are plain text — escape to prevent XSS.
    const contentHTML = who === 'user'
      ? escapeHTML(text).replace(/\n/g, '<br>')
      : text.replace(/\n/g, '<br>');

    row.innerHTML = `
      ${avatarHTML}
      <div class="uv-bubble">
        ${contentHTML}
        <span class="uv-bubble-time">${displayTime}</span>
      </div>
    `;

    messagesEl.insertBefore(row, typingRow);
    scrollToBottom(restored);
  }

  function escapeHTML(str) {
    return str
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');
  }

  function showTyping() {
    typingRow.classList.add('uv-visible');
    scrollToBottom();
  }

  function hideTyping() {
    typingRow.classList.remove('uv-visible');
  }

  function setWaiting(state) {
    isWaiting        = state;
    sendBtn.disabled = state;
    inputEl.disabled = state;
  }

  function insertDivider(label) {
    const div = document.createElement('div');
    div.className = 'uv-history-divider uv-restored';
    div.innerHTML = `<span>${label}</span>`;
    messagesEl.insertBefore(div, typingRow);
  }

  // ── Confirm bar ───────────────────────────────────────────
  function showConfirm() {
    confirmActive = true;
    confirmBar.classList.add('uv-visible');
  }

  function hideConfirm() {
    confirmActive = false;
    confirmBar.classList.remove('uv-visible');
  }

  // ── History restore ───────────────────────────────────────
  async function restoreHistory() {
    try {
      const res  = await fetch(HISTORY_ENDPOINT, {
        headers: {
          'Accept':           'application/json',
          'X-Requested-With': 'XMLHttpRequest',
        }
      });

      if (!res.ok) return;

      const data = await res.json();
      const messages = data.messages ?? [];

      if (messages.length === 0) return;

      // Mark greeting as done so openChat() doesn't append it again
      greetingDone = true;

      insertDivider('Previous conversation');

      messages.forEach(msg => {
        const who = msg.role === 'assistant' ? 'ai' : 'user';
        appendMessage(who, msg.content, formatTime(msg.sent_at), true);
      });

    } catch (err) {
      // Silently fail — user just won't see old messages
      console.warn('[UV Chatbot] History restore failed:', err);
    }
  }

  // ── Reset session ─────────────────────────────────────────
  async function resetSession() {
    hideConfirm();
    setWaiting(true);

    try {
      await fetch(RESET_ENDPOINT, {
          method:  'POST',
          headers: {
              'Content-Type':     'application/json',
              'Accept':           'application/json',
              'X-Requested-With': 'XMLHttpRequest',
              'X-Chat-Session':   sessionToken ?? '',   // ← add this
          },
          // credentials: 'same-origin',   ← remove this line
      });

      // ← add these two lines after the fetch (before UI clear)
      sessionToken = null;
      localStorage.removeItem('uv_chat_session');
    } catch (err) {
      console.warn('[UV Chatbot] Reset request failed:', err);
    }

    // Clear UI regardless of server response
    // Remove all message rows (keep typing row)
    [...messagesEl.querySelectorAll('.uv-msg-row, .uv-history-divider')].forEach(el => el.remove());

    greetingDone = false;
    setWaiting(false);

    // Show fresh greeting
    greetingDone = true;
    setTimeout(() => appendMessage('ai', GREETING), 200);

    inputEl.focus();
  }

  // ── Open / Close ──────────────────────────────────────────
  function openChat() {
    if (isOpen) return;
    isOpen = true;
    chatWindow.classList.add('uv-open');
    inputEl.focus();

    if (!greetingDone) {
      greetingDone = true;
      setTimeout(() => appendMessage('ai', GREETING), 350);
    }
  }

  function closeChat() {
    if (!isOpen) return;
    isOpen = false;
    chatWindow.classList.remove('uv-open');
    hideConfirm();
  }

  // ── Send message ──────────────────────────────────────────
  async function sendMessage() {
    const text = inputEl.value.trim();
    if (!text || isWaiting) return;

    if (confirmActive) hideConfirm();

    inputEl.value = '';
    sendBtn.disabled = true;

    appendMessage('user', text);
    setWaiting(true);
    showTyping();

    try {
      const response = await fetch(ENDPOINT, {
          method:  'POST',
          headers: {
              'Content-Type':     'application/json',
              'Accept':           'application/json',
              'X-Requested-With': 'XMLHttpRequest',
              'X-Chat-Session':   sessionToken ?? '',   // ← add this
          },
          // credentials: 'same-origin',   ← remove this line
          body: JSON.stringify({ message: text }),
      });

      const data = await response.json();

      // ← add this block
      if (data.session_token) {
          sessionToken = data.session_token;
          localStorage.setItem('uv_chat_session', sessionToken);
      }
      hideTyping();

      if (!response.ok) {
        appendMessage('ai', data.reply ?? 'Something went wrong. Please try again.');
        return;
      }

      appendMessage('ai', data.reply ?? "I didn't catch that. Could you try again?");

    } catch (err) {
      hideTyping();
      appendMessage('ai', 'Network error. Please check your connection and try again.');
      console.error('[UV Chatbot]', err);
    } finally {
      setWaiting(false);
    }
  }

  // ── Event Listeners ───────────────────────────────────────
  fab.addEventListener('click', openChat);
  closeBtn.addEventListener('click', closeChat);

  refreshBtn.addEventListener('click', () => {
    if (confirmActive) {
      hideConfirm();
    } else {
      showConfirm();
    }
  });

  confirmYes.addEventListener('click', resetSession);
  confirmNo.addEventListener('click', hideConfirm);

  sendBtn.addEventListener('click', sendMessage);

  inputEl.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' && !e.shiftKey) {
      e.preventDefault();
      sendMessage();
    }
  });

  inputEl.addEventListener('focus', () => {
    // Small delay lets the keyboard finish opening
    setTimeout(() => {
      inputEl.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
      syncToViewport();
      scrollToBottom(true);
    }, 320);
  });

  inputEl.addEventListener('input', () => {
    sendBtn.disabled = inputEl.value.trim().length === 0 || isWaiting;
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      if (confirmActive) { hideConfirm(); return; }
      if (isOpen) closeChat();
    }
  });

  // ── On page load: restore history ────────────────────────
  document.addEventListener('DOMContentLoaded', () => {
    restoreHistory();
  });

  // ── Visual Viewport resize handler (mobile keyboard fix) ──
  function syncToViewport() {
    if (window.innerWidth > 480) return; // desktop: do nothing
    const vv = window.visualViewport;
    if (!vv) return;

    // The viewport shifts up by the keyboard height.
    // We clamp the window to match the visual viewport size.
    chatWindow.style.height = vv.height + 'px';
    chatWindow.style.top    = vv.offsetTop + 'px';
    chatWindow.style.bottom = 'auto';
  }

  if (window.visualViewport) {
    window.visualViewport.addEventListener('resize', syncToViewport);
    window.visualViewport.addEventListener('scroll', syncToViewport);
  }

  // Also reset when keyboard closes / orientation changes
  window.addEventListener('resize', () => {
    if (window.innerWidth > 480) {
      chatWindow.style.height = '';
      chatWindow.style.top    = '';
      chatWindow.style.bottom = '';
    }
  });

})();
</script>




























</body>

</html>
