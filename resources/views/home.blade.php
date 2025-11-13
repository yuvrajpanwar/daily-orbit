@extends('layouts.app')

@push('css')
    <style>
        /* New custom classes to replace conflicting ones */
        .news-section-bg {
            background-color: #f8f9fa;
            padding-top: 50px;
            padding-bottom: 30px;
        }

        .news-banner-container {
            display: none;
        }

        @media (min-width: 992px) {
            .news-banner-container {
                display: block;
            }
        }

        .news-banner-container img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .news-section-title {
            margin-bottom: 30px;
        }

        .news-section-title h4 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0;
        }

        .news-slider-container {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            padding-bottom: 10px;
        }

        .news-card {
            flex: 0 0 auto;
            width: 280px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        .news-card-image {
            position: relative;
            overflow: hidden;
            border-radius: 8px 8px 0 0;
        }

        .news-card-image img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .news-card:hover .news-card-image img {
            transform: scale(1.05);
        }

        .news-card-content {
            padding: 20px;
        }

        .news-card-content h4 {
            font-size: 1.1rem;
            font-weight: 600;
            line-height: 1.4;
            margin-bottom: 10px;
        }

        .news-card-content h4 a {
            color: #333;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .news-card-content h4 a:hover {
            color: #007bff;
        }

        .news-card-meta {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 0;
        }

        /* Scrollbar styling for the slider */
        .news-slider-container::-webkit-scrollbar {
            height: 10px;
        }

        .news-slider-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .news-slider-container::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .news-slider-container::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        .whats-right-img img {
            width: 100% !important;
        }
    </style>
    <style>
    /* Shimmer Container */
    .trending-shimmer {
        position: relative;
        overflow: hidden;
        animation: fadeIn 0.6s ease-out forwards;
        opacity: 0;
    }
    .trending-shimmer:nth-child(1) { animation-delay: 0.1s; }
    .trending-shimmer:nth-child(2) { animation-delay: 0.2s; }

    /* Large Image */
    .shimmer-img-large {
        width: 100%;
        height: 250px;
        border-radius: 12px;
        background: linear-gradient(90deg, #f0f0f0 25%, #e5e5e5 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.8s ease-in-out infinite;
        position: relative;
        overflow: hidden;
    }
    .shimmer-img-large::after {
        content: '';
        position: absolute;
        top: 0; left: -150%;
        width: 50%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6), transparent);
        animation: shine 1.8s ease-in-out infinite;
    }

    /* Text Lines */
    .shimmer-line {
        height: 16px;
        border-radius: 8px;
        background: linear-gradient(90deg, #f0f0f0 25%, #e5e5e5 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.8s ease-in-out infinite;
        margin: 8px 0;
    }
    .shimmer-line.title-long { width: 85%; height: 24px; }
    .shimmer-line.meta       { width: 50%; height: 14px; }
    .shimmer-line.short      { width: 70%; }

    @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
    @keyframes shine   { 0% { left: -150%; } 100% { left: 150%; } }
    @keyframes fadeIn  { to { opacity: 1; } }

    /* Real Content Animation */
    #trending-content .whats-news-single {
        animation: fadeInContent 0.6s ease-out forwards;
        opacity: 0;
        transform: translateY(10px);
    }
    #trending-content .whats-news-single:nth-child(1) { animation-delay: 0.1s; }
    #trending-content .whats-news-single:nth-child(2) { animation-delay: 0.2s; }

    @keyframes fadeInContent {
        to { opacity: 1; transform: translateY(0); }
    }

    /* Real Image */
    .trending-real-img {
        width: 100%; height: 250px; object-fit: cover; border-radius: 12px;
        transition: transform 0.4s ease;
    }
    .trending-real-img:hover { transform: scale(1.03); }

    /* Typography */
    .trending-real-title {
        font-size: 1.4rem; line-height: 1.3; font-weight: 700; margin: 12px 0 6px;
        color: #1a1a1a;
    }
    .trending-real-title a { color: inherit; text-decoration: none; }
    .trending-real-title a:hover { color: #ff4757; }

    .trending-real-meta {
        font-size: 0.9rem; color: #666; font-weight: 500;
    }

    .trending-real-excerpt {
        font-size: 0.95rem; color: #444; line-height: 1.6; margin-top: 10px;
    }
    .whats-news-area .most-recent-area .most-recent .most-recent-img::before{
        /* background:white!important; */
    }
</style>

<style>
    /* Fade-in Animation */
    #recent-loading > div {
        animation: fadeIn 0.6s ease-out forwards;
        opacity: 0;
    }
    #recent-loading > div:nth-child(1) { animation-delay: 0.1s; }
    #recent-loading > div:nth-child(2) { animation-delay: 0.2s; }
    #recent-loading > div:nth-child(3) { animation-delay: 0.3s; }

    /* Large Featured Post */
    .shimmer-img-large {
        width: 100%;
        height: 280px;
        background: linear-gradient(90deg, #f0f0f0 25%, #e5e5e5 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.8s ease-in-out infinite;
        position: relative;
        overflow: hidden;
    }
    .shimmer-img-large::after {
        content: '';
        position: absolute;
        top: 0; left: -150%;
        width: 50%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6), transparent);
        animation: shine 1.8s ease-in-out infinite;
    }

    /* Small Thumbnails */
    .shimmer-img-small {
        width: 80px; height: 80px;
        border-radius: 10px;
        background: linear-gradient(90deg, #f0f0f0 25%, #e5e5e5 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.8s ease-in-out infinite;
        position: relative;
        overflow: hidden;
    }
    .shimmer-img-small::after {
        content: '';
        position: absolute;
        top: 0; left: -150%;
        width: 50%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6), transparent);
        animation: shine 1.8s ease-in-out infinite;
    }

    /* Text Lines */
    .shimmer-line {
        height: 14px;
        border-radius: 7px;
        background: linear-gradient(90deg, #f0f0f0 25%, #e5e5e5 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.8s ease-in-out infinite;
        margin: 6px 0;
    }
    .shimmer-line.badge       { width: 60px; height: 20px; }
    .shimmer-line.title-long  { width: 80%; height: 26px; }
    .shimmer-line.title-medium{ width: 90%; height: 18px; }
    .shimmer-line.meta        { width: 60%; height: 14px; }

    @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
    @keyframes shine   { 0% { left: -150%; } 100% { left: 150%; } }
    @keyframes fadeIn  { to { opacity: 1; } }

    /* Real Content Animation */
    #recent-content > div {
        animation: fadeInContent 0.6s ease-out forwards;
        opacity: 0;
        transform: translateY(8px);
    }
    #recent-content > div:nth-child(1) { animation-delay: 0.1s; }
    #recent-content > div:nth-child(2) { animation-delay: 0.2s; }
    #recent-content > div:nth-child(3) { animation-delay: 0.3s; }

    @keyframes fadeInContent {
        to { opacity: 1; transform: translateY(0); }
    }

    /* Real Images */
    .recent-real-img-large {
        width: 100%; height: 280px; object-fit: cover; border-radius: 12px;
        transition: transform 0.4s ease;
    }
    .recent-real-img-large:hover { transform: scale(1.02); }

    .recent-real-img-small {
        width: 80px; height: 80px; object-fit: cover; border-radius: 10px;
        transition: transform 0.3s ease;
    }
    .recent-real-img-small:hover { transform: scale(1.08); }

    /* Typography */
    .recent-real-badge {
        display: inline-block;
        background: #ff4757;
        color: white;
        font-size: 12px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
        margin-bottom: 8px;
    }

    .recent-real-title {
        font-size: 1.35rem; line-height: 1.3; font-weight: 700; margin: 8px 0;
        color: #1a1a1a;
    }
    .recent-real-title a { color: inherit; text-decoration: none; }
    .recent-real-title a:hover { color: #ff4757; }

    .recent-real-meta {
        font-size: 0.85rem; color: #666; font-weight: 500;
    }

    .recent-real-title-small {
        font-size: 1rem; line-height: 1.4; font-weight: 600; margin: 0;
        color: #1a1a1a;
    }
    .recent-real-title-small a { color: inherit; text-decoration: none; }
    .recent-real-title-small a:hover { color: #ff4757; }
</style>

<style>
    /* Staggered Fade-in */
    #popular-slider-loading .weekly3-single {
        animation: fadeIn 0.6s ease-out forwards;
        opacity: 0;
    }
    #popular-slider-loading .weekly3-single:nth-child(1) { animation-delay: 0.1s; }
    #popular-slider-loading .weekly3-single:nth-child(2) { animation-delay: 0.2s; }
    #popular-slider-loading .weekly3-single:nth-child(3) { animation-delay: 0.3s; }
    #popular-slider-loading .weekly3-single:nth-child(4) { animation-delay: 0.4s; }
    #popular-slider-loading .weekly3-single:nth-child(5) { animation-delay: 0.5s; }

    /* Slider Image */
    .shimmer-img-slider {
        width: 100%;
        height: 180px;
        border-radius: 12px;
        background: linear-gradient(90deg, #f0f0f0 25%, #e5e5e5 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.8s ease-in-out infinite;
        position: relative;
        overflow: hidden;
    }
    .shimmer-img-slider::after {
        content: '';
        position: absolute;
        top: 0; left: -150%;
        width: 50%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6), transparent);
        animation: shine 1.8s ease-in-out infinite;
    }

    /* Text Lines */
    .shimmer-line {
        height: 16px;
        border-radius: 8px;
        background: linear-gradient(90deg, #f0f0f0 25%, #e5e5e5 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.8s ease-in-out infinite;
        margin: 8px 0;
    }
    .shimmer-line.title { width: 85%; height: 20px; }
    .shimmer-line.meta  { width: 55%; height: 14px; }

    @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
    @keyframes shine   { 0% { left: -150%; } 100% { left: 150%; } }
    @keyframes fadeIn  { to { opacity: 1; } }

    /* Real Content */
    #popular-slider-content .weekly3-single {
        animation: fadeInContent 0.6s ease-out forwards;
        opacity: 0;
        transform: translateY(8px);
    }
    #popular-slider-content .weekly3-single:nth-child(1) { animation-delay: 0.1s; }
    #popular-slider-content .weekly3-single:nth-child(2) { animation-delay: 0.2s; }
    #popular-slider-content .weekly3-single:nth-child(3) { animation-delay: 0.3s; }
    #popular-slider-content .weekly3-single:nth-child(4) { animation-delay: 0.4s; }
    #popular-slider-content .weekly3-single:nth-child(5) { animation-delay: 0.5s; }

    @keyframes fadeInContent {
        to { opacity: 1; transform: translateY(0); }
    }

    .popular-real-img {
        width: 100%; height: 225px; object-fit: cover; border-radius: 12px;
        transition: transform 0.4s ease;
    }
    .popular-real-img:hover { transform: scale(1.03); }

    .popular-real-title {
        font-size: 1.1rem; line-height: 1.4; font-weight: 600; margin: 12px 0 6px;
        color: #1a1a1a;
    }
    .popular-real-title a { color: inherit; text-decoration: none; }
    .popular-real-title a:hover { color: #ff4757; }

    .popular-real-date {
        font-size: 0.85rem; color: #666; font-weight: 500;
    }

    .slick-arrow{
        display:none !important;
    }
</style>
<style>
    /* Staggered Fade-in */
    #youmightlike-loading .news-card {
        animation: fadeIn 0.6s ease-out forwards;
        opacity: 0;
    }
    #youmightlike-loading .news-card:nth-child(1) { animation-delay: 0.1s; }
    #youmightlike-loading .news-card:nth-child(2) { animation-delay: 0.2s; }
    #youmightlike-loading .news-card:nth-child(3) { animation-delay: 0.3s; }
    #youmightlike-loading .news-card:nth-child(4) { animation-delay: 0.4s; }

    /* Card Image */
    .shimmer-img-card {
        width: 100%;
        height: 180px;
        border-radius: 8px;
        background: linear-gradient(90deg, #f0f0f0 25%, #e5e5e5 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.8s ease-in-out infinite;
        position: relative;
        overflow: hidden;
    }
    .shimmer-img-card::after {
        content: '';
        position: absolute;
        top: 0; left: -150%;
        width: 50%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6), transparent);
        animation: shine 1.8s ease-in-out infinite;
    }

    /* Text Lines */
    .shimmer-line {
        height: 16px;
        border-radius: 8px;
        background: linear-gradient(90deg, #f0f0f0 25%, #e5e5e5 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.8s ease-in-out infinite;
        margin: 8px 0;
    }
    .shimmer-line.title { width: 85%; height: 20px; }
    .shimmer-line.meta  { width: 60%; height: 14px; }

    @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
    @keyframes shine   { 0% { left: -150%; } 100% { left: 150%; } }
    @keyframes fadeIn  { to { opacity: 1; } }

    /* Real Content Fade-in */
    #youmightlike-content .news-card {
        animation: fadeInContent 0.6s ease-out forwards;
        opacity: 0;
        transform: translateY(8px);
    }
    #youmightlike-content .news-card:nth-child(1) { animation-delay: 0.1s; }
    #youmightlike-content .news-card:nth-child(2) { animation-delay: 0.2s; }
    #youmightlike-content .news-card:nth-child(3) { animation-delay: 0.3s; }
    #youmightlike-content .news-card:nth-child(4) { animation-delay: 0.4s; }

    @keyframes fadeInContent {
        to { opacity: 1; transform: translateY(0); }
    }

    /* Real Image */
    .youmightlike-real-img {
        width: 100%; height: 180px; object-fit: cover; border-radius: 8px;
        transition: transform 0.4s ease;
    }
    .youmightlike-real-img:hover { transform: scale(1.05); }

    /* Typography */
    .youmightlike-real-title {
        font-size: 1.1rem; line-height: 1.4; font-weight: 600; margin: 12px 0 6px;
        color: #333;
    }
    .youmightlike-real-title a { color: inherit; text-decoration: none; }
    .youmightlike-real-title a:hover { color: #007bff; }

    .youmightlike-real-meta {
        font-size: 0.9rem; color: #666;
    }

    .slick-dots{
        display:none;
    }
</style>
@endpush


@section('main')
    <main>

        <section class="whats-news-area pt-10 pb-20 gray-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="whats-news-wrapper" style="padding: 10px 20px 20px;">
                            <!-- Heading & Nav Button -->
                            <div class="row justify-content-between align-items-end mb-15">
                                <div class="col-xl-4">
                                    <div class="section-tittle">
                                       <h3>Trending</h3>      
                                       <h4 style="white-space: nowrap">{{date('d M Y | h:i A')}}</h4>                              
                                    </div>
                                </div>
                            </div>
                            <!-- Tab content -->
                            <div class="row">
                                <div class="col-12">
                                    <!-- Nav Card -->
                                    <div class="tab-content" id="nav-tabContent">
                                        <!-- Trending Tab -->
                                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                            
                                            {{-- Shimmer Skeleton --}}
                                            <div id="trending-loading" class="row g-4">
                                                @for($i = 0; $i < 2; $i++)
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
                        <div class="banner-one mt-20 mb-30">
                            <img src="assets/img/gallery/body_card1.png" alt="">
                        </div>
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
                                        <div class="shimmer-img-large" style="border-radius: 12px 12px 0 0 !important;"></div>
                                        <div class="most-recent-cap">
                                            <div class="shimmer-line badge"></div>
                                            <div class="shimmer-line title-long mt-2"></div>
                                            <div class="shimmer-line meta mt-1"></div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Two Small Cards --}}
                                @for($i = 0; $i < 2; $i++)
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
                                    @for($i = 0; $i < 5; $i++)
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
                                <div id="popular-slider-content" class="weekly3-news-active dot-style d-flex" style="display: none;"></div>

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
                    <div class="col-lg-3">
                        <div class="news-banner-container">
                            <img src="assets/img/gallery/body_card2.png" alt="Travel Banner">
                        </div>
                    </div>

                    <!-- News Content Column -->
                    <div class="col-lg-9">

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
                                    @for($i = 0; $i < 4; $i++)
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
                                <div id="youmightlike-content" class="news-slider-container draggable" style="display: none;"></div>

                            </div>
                        </div>
                        {{-- end you might like section --}}


                    </div>
                </div>
            </div>
        </div>

        <div class="banner-area gray-bg pt-90 pb-90">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-md-10">
                        <div class="banner-one">
                            <img src="assets/img/gallery/body_card3.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection

@push('scripts')

{{-- trending ajax --}}
<script>
    $(document).ready(function() {
        $.ajax({
            url: '{{ route("post.trending") }}',
            method: 'GET',
            cache: true,
            success: function(posts) {
                let html = '';
                posts.forEach(function(p) {
                    html += `
                        <div class="col-xl-6 col-lg-6">
                            <div class="whats-news-single m-1 p-3 bg-light rounded">
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
                $('#trending-loading').html('<p class="text-center text-muted">Failed to load trending posts.</p>');
            }
        });
    });
</script>

{{-- most recent ajax --}}
<script>
    $(document).ready(function() {
        $.ajax({
            url: '{{ route("post.recent") }}',
            method: 'GET',
            cache: true,
            success: function(posts) {
                let html = '';

                posts.forEach(function(p, index) {
                    if (p.is_first) {
                        // First large card
                        html += `
                            <div class="most-recent mb-40">
                                <div class="most-recent-img">
                                    <img src="${p.image}" alt="${p.title}" class="recent-real-img-large">
                                    <div class="most-recent-cap">
                                        <span class="recent-real-badge bgbeg">New</span>
                                        <h4 class="recent-real-title">
                                            <a href="${p.post_url}">${p.title}</a>
                                        </h4>
                                        <p class="recent-real-meta">${p.author_name} | ${p.time_ago}</p>
                                    </div>
                                </div>
                            </div>`;
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
                $('#recent-loading').html('<p class="text-center text-muted">Failed to load recent posts.</p>');
            }
        });
    });
</script>

{{-- most popular slider --}}
<script>
    $(document).ready(function() {
        $.ajax({
            url: '{{ route("post.mostpopular") }}',
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
                        if ($('.weekly3-news-active').hasClass('slick-initialized')) {
                            $('.weekly3-news-active').slick('unslick');
                        }
                        $('#popular-slider-content').slick({
                            dots: true,
                            infinite: true,
                            speed: 500,
                            slidesToShow: 4,
                            slidesToScroll: 1,
                            responsive: [
                                { breakpoint: 1200, settings: { slidesToShow: 3 } },
                                { breakpoint: 992,  settings: { slidesToShow: 2 } },
                                { breakpoint: 768,  settings: { slidesToShow: 1 } }
                            ]
                        });
                    });
                });
            },
            error: function() {
                $('#popular-slider-loading').html('<p class="text-center text-muted">Failed to load.</p>');
            }
        });
    });
</script>

{{-- you might like  --}}
<script>
    $(document).ready(function() {
        $.ajax({
            url: '{{ route("post.youmightlike") }}',
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
                $('#youmightlike-loading').html('<p class="text-center text-muted">Failed to load suggestions.</p>');
            }
        });
    });
</script>

@endpush