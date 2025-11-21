@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/homepage.min.css') }}">
@endpush


@section('main')
    <main>

        <section class="whats-news-area pt-10 pb-20 gray-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="whats-news-wrapper" style="padding: 10px 10px 20px;">
                            <!-- Heading & Nav Button -->
                            <div class="row justify-content-between align-items-end mb-15">
                                <div class="col-xl-4">
                                    <div class="section-tittle">
                                        <h3>Trending</h3>
                                        <h4 style="white-space: nowrap">{{ date('d M Y | h:i A') }}</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- Tab content -->
                            <div class="row">
                                <div>
                                    <!-- Nav Card -->
                                    <div class="tab-content" id="nav-tabContent">
                                        <!-- Trending Tab -->
                                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                            aria-labelledby="nav-home-tab">

                                            {{-- Shimmer Skeleton --}}
                                            <div id="trending-loading" class="row g-4">
                                                @for ($i = 0; $i < 2; $i++)
                                                    <div class="col-xl-6 col-lg-6">
                                                        <div class="trending-shimmer m-1 p-3 bg-light rounded">
                                                            <div class="shimmer-img-large"></div>
                                                            <div class="shimmer-text mt-3">
                                                                <div class="shimmer-line title-long"></div>
                                                                <div class="shimmer-line meta"></div>
                                                                <div class="shimmer-line short mt-2"></div>
                                                                <div class="shimmer-line short"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endfor
                                            </div>

                                            {{-- Real Content (hidden) --}}
                                            <div id="trending-content" class="row g-4" style="display: none;"></div>
                                        </div>
                                    </div>
                                    <!-- End Nav Card -->
                                </div>
                            </div>
                        </div>
                        <!-- Banner -->
                        {{-- <div class="banner-one mt-20 mb-30">
                            <img src="assets/img/gallery/body_card1.png" alt="">
                        </div> --}}
                    </div>
                    <div class="col-lg-4">

                        <!-- Most Recent Area -->
                        <div class="most-recent-area pt-2">
                            <!-- Section Tittle -->
                            <div class="section-tittle mb-20">
                                <h3>Most Recent</h3>
                            </div>

                            {{-- Shimmer Skeleton --}}
                            <div id="recent-loading">
                                {{-- First Large Card --}}
                                <div class="most-recent mb-40">
                                    <div class="most-recent-img">
                                        <div class="shimmer-img-large" style="border-radius: 12px 12px 0 0 !important;">
                                        </div>
                                        <div class="most-recent-cap">
                                            <div class="shimmer-line badge"></div>
                                            <div class="shimmer-line title-long mt-2"></div>
                                            <div class="shimmer-line meta mt-1"></div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Two Small Cards --}}
                                @for ($i = 0; $i < 2; $i++)
                                    <div class="most-recent-single mb-3">
                                        <div class="most-recent-images">
                                            <div class="shimmer-img-small"></div>
                                        </div>
                                        <div class="most-recent-capt" style="width: 100%">
                                            <div class="shimmer-line title-medium"></div>
                                            <div class="shimmer-line meta"></div>
                                        </div>
                                    </div>
                                @endfor
                            </div>

                            {{-- Real Content (hidden) --}}
                            <div id="recent-content" style="display: none;"></div>
                        </div>

                        <!-- Flow Socail -->
                        <div class="single-follow mb-45 bg-light">
                            <div class="single-box">
                                <div class="follow-us d-flex align-items-center">
                                    <div class="follow-social">
                                        <a href="#"><img src="assets/img/news/icon-fb.png" alt=""></a>
                                    </div>
                                    <div class="follow-count">
                                        <span>8,045</span>
                                        <p>Fans</p>
                                    </div>
                                </div>
                                <div class="follow-us d-flex align-items-center">
                                    <div class="follow-social">
                                        <a href="#"><img src="assets/img/news/icon-tw.png" alt=""></a>
                                    </div>
                                    <div class="follow-count">
                                        <span>8,045</span>
                                        <p>Fans</p>
                                    </div>
                                </div>
                                <div class="follow-us d-flex align-items-center">
                                    <div class="follow-social">
                                        <a href="#"><img src="assets/img/news/icon-ins.png" alt=""></a>
                                    </div>
                                    <div class="follow-count">
                                        <span>8,045</span>
                                        <p>Fans</p>
                                    </div>
                                </div>
                                <div class="follow-us d-flex align-items-center">
                                    <div class="follow-social">
                                        <a href="#"><img src="assets/img/news/icon-yo.png" alt=""></a>
                                    </div>
                                    <div class="follow-count">
                                        <span>8,045</span>
                                        <p>Fans</p>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </section>





        <div class="weekly3-news-area pt-30 pb-130 bg-light">
            <div class="container">
                <div class="weekly3-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="slider-wrapper">

                                <!-- Title -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="section-tittle mb-30">
                                            <h3>Most Popular</h3>
                                        </div>
                                    </div>
                                </div>

                                <!-- Slider Container -->
                                <div class="row">
                                    <div class="col-lg-12">

                                        <!-- Shimmer Skeleton -->
                                        <div id="popular-slider-loading" class="weekly3-news-active dot-style d-flex">
                                            @for ($i = 0; $i < 5; $i++)
                                                <div class="weekly3-single">
                                                    <div class="weekly3-img">
                                                        <div class="shimmer-img-slider"></div>
                                                    </div>
                                                    <div class="weekly3-caption mt-3">
                                                        <div class="shimmer-line title"></div>
                                                        <div class="shimmer-line meta"></div>
                                                    </div>
                                                </div>
                                            @endfor
                                        </div>

                                        <!-- Real Content (hidden) -->
                                        <div id="popular-slider-content" class="weekly3-news-active dot-style d-flex"
                                            style="display: none;"></div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>






        <div class="news-section-bg bg-white pt-4">
            <div class="container">
                <div class="row">
                    <!-- Banner Column -->
                    {{-- <div class="col-lg-3">
                        <div class="news-banner-container">
                            <img src="assets/img/gallery/body_card2.png" alt="Travel Banner">
                        </div>
                    </div> --}}

                    <!-- News Content Column -->
                    <div class="col-12">

                        {{-- start you might like section --}}
                        <!-- section Tittle -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section-tittle mb-30">
                                    <h3>You Might Like</h3>
                                </div>
                            </div>
                        </div>

                        <!-- News Slider -->
                        <div class="row">
                            <div class="col-12">

                                <!-- Shimmer Skeleton -->
                                <div id="youmightlike-loading" class="news-slider-container draggable">
                                    @for ($i = 0; $i < 4; $i++)
                                        <div class="news-card">
                                            <div class="news-card-image">
                                                <div class="shimmer-img-card"></div>
                                            </div>
                                            <div class="news-card-content">
                                                <div class="shimmer-line title mt-3"></div>
                                                <div class="shimmer-line meta"></div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>

                                <!-- Real Content (hidden) -->
                                <div id="youmightlike-content" class="news-slider-container draggable"
                                    style="display: none;"></div>

                            </div>
                        </div>
                        {{-- end you might like section --}}


                    </div>
                </div>
            </div>
        </div>

        <div class="banner-area gray-bg pt-90 pb-90">
            {{-- <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-md-10">
                        <div class="banner-one">
                            <img src="assets/img/gallery/body_card3.png" alt="">
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>

    </main>
@endsection

@push('scripts')
    {{-- trending ajax --}}
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '{{ route('post.trending') }}',
                method: 'GET',
                cache: true,
                success: function(posts) {
                    let html = '';
                    posts.forEach(function(p) {
                        html += `
                        <div class="col-xl-6 col-lg-6">
                            <div class="whats-news-single m-1 py-3 px-2 bg-light rounded">
                                <div class="whates-img">
                                    <img src="${p.image}" alt="${p.title}" class="trending-real-img">
                                </div>
                                <div class="whates-caption">
                                    <h4 class="trending-real-title">
                                        <a href="${p.post_url}">${p.title}</a>
                                    </h4>
                                    <span class="trending-real-meta">by ${p.author_name} - ${p.time_ago}</span>
                                    <p class="trending-real-excerpt">${p.excerpt}</p>
                                </div>
                            </div>
                        </div>`;
                    });

                    $('#trending-loading').fadeOut(400, function() {
                        $('#trending-content').html(html).fadeIn(500);
                    });
                },
                error: function() {
                    $('#trending-loading').html(
                        '<p class="text-center text-muted">Failed to load trending posts.</p>');
                }
            });
        });
    </script>

    {{-- most recent ajax --}}
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '{{ route('post.recent') }}',
                method: 'GET',
                cache: true,
                success: function(posts) {
                    let html = '';

                    posts.forEach(function(p, index) {
                        if (p.is_first) {
                            // First large card
                            html += `
                            <a href="${p.post_url}">
                                <div class="most-recent mb-40">
                                    <div class="most-recent-img">
                                        <img src="${p.image}" alt="${p.title}" class="recent-real-img-large">
                                        <div class="most-recent-cap">
                                            <span class="recent-real-badge bgbeg">New</span>
                                            <h4 class="recent-real-title text-white">
                                                ${p.title}
                                            </h4>
                                            <p class="recent-real-meta">${p.author_name} | ${p.time_ago}</p>
                                        </div>
                                    </div>
                                </div> 
                            </a>`;
                        } else {
                            // Small cards
                            html += `
                            <div class="most-recent-single mb-3">
                                <div class="most-recent-images">
                                    <img src="${p.image}" alt="${p.title}" class="recent-real-img-small">
                                </div>
                                <div class="most-recent-capt">
                                    <h4 class="recent-real-title-small">
                                        <a href="${p.post_url}">${p.title}</a>
                                    </h4>
                                    <p class="recent-real-meta">${p.author_name} | ${p.time_ago}</p>
                                </div>
                            </div>`;
                        }
                    });

                    $('#recent-loading').fadeOut(400, function() {
                        $('#recent-content').html(html).fadeIn(500);
                    });
                },
                error: function() {
                    $('#recent-loading').html(
                        '<p class="text-center text-muted">Failed to load recent posts.</p>');
                }
            });
        });
    </script>

    {{-- most popular slider --}}
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '{{ route('post.mostpopular') }}',
                method: 'GET',
                cache: true,
                success: function(posts) {
                    let html = '';
                    posts.forEach(function(p) {
                        html += `
                        <div class="weekly3-single">
                            <div class="weekly3-img">
                                <img src="${p.image}" alt="${p.title}" class="popular-real-img">
                            </div>
                            <div class="weekly3-caption">
                                <h4 class="popular-real-title">
                                    <a href="${p.post_url}">${p.title}</a>
                                </h4>
                                <p class="popular-real-date">${p.date}</p>
                            </div>
                        </div>`;
                    });

                    $('#popular-slider-loading').fadeOut(300, function() {
                        $(this).remove(); // Remove shimmer
                        $('#popular-slider-content').html(html).fadeIn(500, function() {
                            // Re-init Slick
                            if ($('.weekly3-news-active').hasClass(
                                    'slick-initialized')) {
                                $('.weekly3-news-active').slick('unslick');
                            }
                            $('#popular-slider-content').slick({
                                dots: true,
                                infinite: true,
                                speed: 500,
                                slidesToShow: 4,
                                slidesToScroll: 1,
                                responsive: [{
                                        breakpoint: 1200,
                                        settings: {
                                            slidesToShow: 3
                                        }
                                    },
                                    {
                                        breakpoint: 992,
                                        settings: {
                                            slidesToShow: 2
                                        }
                                    },
                                    {
                                        breakpoint: 768,
                                        settings: {
                                            slidesToShow: 1
                                        }
                                    }
                                ]
                            });
                        });
                    });
                },
                error: function() {
                    $('#popular-slider-loading').html(
                        '<p class="text-center text-muted">Failed to load.</p>');
                }
            });
        });
    </script>

    {{-- you might like  --}}
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '{{ route('post.youmightlike') }}',
                method: 'GET',
                cache: true,
                success: function(posts) {
                    let html = '';
                    posts.forEach(function(p) {
                        html += `
                        <div class="news-card">
                            <div class="news-card-image">
                                <img src="${p.image}" alt="${p.title}" class="youmightlike-real-img">
                            </div>
                            <div class="news-card-content">
                                <h4 class="youmightlike-real-title">
                                    <a href="${p.post_url}">${p.title}</a>
                                </h4>
                                <p class="youmightlike-real-meta news-card-meta">${p.author_name} | ${p.time_ago}</p>
                            </div>
                        </div>`;
                    });

                    $('#youmightlike-loading').fadeOut(300, function() {
                        $(this).remove(); // Remove shimmer
                        $('#youmightlike-content').html(html).fadeIn(500);
                    });
                },
                error: function() {
                    $('#youmightlike-loading').html(
                        '<p class="text-center text-muted">Failed to load suggestions.</p>');
                }
            });
        });
    </script>


    <script>
        document.addEventListener("click", function(e) {
            const img = e.target;

            if (img.tagName.toLowerCase() !== "img") return;

            let link = null;

            // 1. Search sibling links inside the same parent container
            let parent = img.parentElement;
            if (parent) {
                link = [...parent.children].find(el =>
                    el.tagName.toLowerCase() === "a" || el.querySelector("a")
                );
                if (link) link = link.tagName.toLowerCase() === "a" ? link : link.querySelector("a");
            }

            // 2. If no sibling link found → search ancestors for any child <a>
            if (!link) {
                let ancestor = img.parentElement;
                while (ancestor && !link) {
                    link = ancestor.querySelector("a");
                    ancestor = ancestor.parentElement;
                }
            }

            // 3. Redirect if found
            if (link && link.href) {

                // 🔥 Show preloader before redirect
                const loader = document.getElementById("preloader-active");
                if (loader) loader.style.display = "flex";

                window.location.href = link.href;
            }
        });
    </script>
@endpush
