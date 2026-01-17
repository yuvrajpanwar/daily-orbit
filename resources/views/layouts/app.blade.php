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
        
        <!-- 4. Robots – don’t block anything -->
        <meta name="robots" content="index, follow">
    
        <!-- 5. Canonical URL (prevents duplicate issues) -->
        <link rel="canonical" href="{{ request()->url() }}">
    
        <!-- 6. Favicon (you have it – good) -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/assets/img/favicon.ico') }}">
    
        <!-- 7. Open Graph / Social Tags (huge for sharing & indirect SEO) -->
        <meta property="og:title" content="@yield('title', 'Daily Orbit - Latest Trending News')">
        <meta property="og:description" content="@yield('meta_description', 'Daily Orbit brings you the latest trending news...')">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ request()->url() }}">
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
    <script src="{{ asset('assets/js/jquery.scrollUp.min.js') }}"></script>
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
</body>

</html>
