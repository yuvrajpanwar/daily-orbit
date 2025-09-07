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
@endpush


@section('main')
    <main>

        <section class="whats-news-area pt-10 pb-20 gray-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="whats-news-wrapper">
                            <!-- Heading & Nav Button -->
                            <div class="row justify-content-between align-items-end mb-15">
                                <div class="col-xl-4">
                                    <div class="section-tittle">
                                        <h3>Trending</h3>                                      
                                    </div>
                                </div>
                            </div>
                            <!-- Tab content -->
                            <div class="row">
                                <div class="col-12">
                                    <!-- Nav Card -->
                                    <div class="tab-content" id="nav-tabContent">
                                        <!-- card one -->
                                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                            aria-labelledby="nav-home-tab">
                                            <div class="row g-4">
                                                <!-- Left Details Caption -->
                                                <div class="col-xl-6 col-lg-6">
                                                    <div class="whats-news-single m-1 p-3 bg-light rounded">
                                                        <div class="whates-img">
                                                            <img src="assets/img/gallery/whats_news_details1.png"
                                                                alt="">
                                                        </div>
                                                        <div class="whates-caption">
                                                            <h4><a href="latest_news.html">Secretart for Economic Air plane
                                                                    that looks like</a></h4>
                                                            <span>by Alice cloe - Jun 19, 2020</span>
                                                            <p>Struggling to sell one multi-million dollar home currently on
                                                                the market won’t stop actress and singer Jennifer Lopez.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-lg-6">
                                                    <div class="whats-news-single m-1 p-3 bg-light rounded">
                                                        <div class="whates-img">
                                                            <img src="assets/img/gallery/whats_news_details1.png"
                                                                alt="">
                                                        </div>
                                                        <div class="whates-caption">
                                                            <h4><a href="latest_news.html">Secretart for Economic Air plane
                                                                    that looks like</a></h4>
                                                            <span>by Alice cloe - Jun 19, 2020</span>
                                                            <p>Struggling to sell one multi-million dollar home currently on
                                                                the market won’t stop actress and singer Jennifer Lopez.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
                        <!-- Most Recent Area -->
                        <div class="most-recent-area pt-2">
                            <!-- Section Tittle -->
                            <div class="section-tittle mb-20">
                                <h3>Most Recent</h3>
                            </div>
                            <!-- Details -->
                            <div class="most-recent mb-40">
                                <div class="most-recent-img">
                                    <img src="assets/img/gallery/most_recent.png" alt="">
                                    <div class="most-recent-cap">
                                        <span class="bgbeg">Vogue</span>
                                        <h4><a href="latest_news.html">What to Wear: 9+ Cute Work <br>
                                                Outfits to Wear This.</a></h4>
                                        <p>Jhon | 2 hours ago</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Single -->
                            <div class="most-recent-single">
                                <div class="most-recent-images">
                                    <img src="assets/img/gallery/most_recent1.png" alt="">
                                </div>
                                <div class="most-recent-capt">
                                    <h4><a href="latest_news.html">Scarlett’s disappointment at latest accolade</a></h4>
                                    <p>Jhon | 2 hours ago</p>
                                </div>
                            </div>
                            <!-- Single -->
                            <div class="most-recent-single">
                                <div class="most-recent-images">
                                    <img src="assets/img/gallery/most_recent2.png" alt="">
                                </div>
                                <div class="most-recent-capt">
                                    <h4><a href="latest_news.html">Most Beautiful Things to Do in Sidney with Your BF</a>
                                    </h4>
                                    <p>Jhon | 3 hours ago</p>
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
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="section-tittle mb-30">
                                            <h3>Most Popular</h3>
                                        </div>
                                    </div>
                                </div>
                                <!-- Slider -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="weekly3-news-active dot-style d-flex">
                                            <div class="weekly3-single">
                                                <div class="weekly3-img">
                                                    <img src="assets/img/gallery/weekly2News1.png" alt="">
                                                </div>
                                                <div class="weekly3-caption">
                                                    <h4><a href="latest_news.html">What to Expect From the 2020 Oscar Nomin
                                                            ations</a></h4>
                                                    <p>19 Jan 2020</p>
                                                </div>
                                            </div>
                                            <div class="weekly3-single">
                                                <div class="weekly3-img">
                                                    <img src="assets/img/gallery/weekly2News2.png" alt="">
                                                </div>
                                                <div class="weekly3-caption">
                                                    <h4><a href="latest_news.html">What to Expect From the 2020 Oscar Nomin
                                                            ations</a></h4>
                                                    <p>19 Jan 2020</p>
                                                </div>
                                            </div>
                                            <div class="weekly3-single">
                                                <div class="weekly3-img">
                                                    <img src="assets/img/gallery/weekly2News3.png" alt="">
                                                </div>
                                                <div class="weekly3-caption">
                                                    <h4><a href="latest_news.html">What to Expect From the 2020 Oscar Nomin
                                                            ations</a></h4>
                                                    <p>19 Jan 2020</p>
                                                </div>
                                            </div>
                                            <div class="weekly3-single">
                                                <div class="weekly3-img">
                                                    <img src="assets/img/gallery/weekly2News4.png" alt="">
                                                </div>
                                                <div class="weekly3-caption">
                                                    <h4><a href="latest_news.html">What to Expect From the 2020 Oscar Nomin
                                                            ations</a></h4>
                                                    <p>19 Jan 2020</p>
                                                </div>
                                            </div>
                                            <div class="weekly3-single">
                                                <div class="weekly3-img">
                                                    <img src="assets/img/gallery/weekly2News2.png" alt="">
                                                </div>
                                                <div class="weekly3-caption">
                                                    <h4><a href="latest_news.html">What to Expect From the 2020 Oscar Nomin
                                                            ations</a></h4>
                                                    <p>19 Jan 2020</p>
                                                </div>
                                            </div>
                                        </div>
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
                        <!-- section Tittle -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section-tittle mb-30">
                                    <h3>You Might Like</he>
                                </div>
                            </div>
                        </div>

                        <!-- News Slider -->
                        <div class="row">
                            <div class="col-12">
                                <div class="news-slider-container draggable">
                                    <!-- News Card 1 -->
                                    <div class="news-card">
                                        <div class="news-card-image">
                                            <img src="assets/img/gallery/weeklyNews1.png" alt="News Image">
                                        </div>
                                        <div class="news-card-content">
                                            <h4>
                                                <a href="#">Scarlett's disappointment at latest accolade</a>
                                            </h4>
                                            <p class="news-card-meta">Jhon | 2 hours ago</p>
                                        </div>
                                    </div>

                                    <!-- News Card 2 -->
                                    <div class="news-card">
                                        <div class="news-card-image">
                                            <img src="assets/img/gallery/weeklyNews1.png" alt="News Image">
                                        </div>
                                        <div class="news-card-content">
                                            <h4>
                                                <a href="#">Scarlett's disappointment at latest accolade</a>
                                            </h4>
                                            <p class="news-card-meta">Jhon | 2 hours ago</p>
                                        </div>
                                    </div>

                                    <!-- News Card 3 -->
                                    <div class="news-card">
                                        <div class="news-card-image">
                                            <img src="assets/img/gallery/weeklyNews1.png" alt="News Image">
                                        </div>
                                        <div class="news-card-content">
                                            <h4>
                                                <a href="#">Scarlett's disappointment at latest accolade</a>
                                            </h4>
                                            <p class="news-card-meta">Jhon | 2 hours ago</p>
                                        </div>
                                    </div>

                                    <!-- News Card 4 -->
                                    <div class="news-card">
                                        <div class="news-card-image">
                                            <img src="assets/img/gallery/weeklyNews1.png" alt="News Image">
                                        </div>
                                        <div class="news-card-content">
                                            <h4>
                                                <a href="#">Scarlett's disappointment at latest accolade</a>
                                            </h4>
                                            <p class="news-card-meta">Jhon | 2 hours ago</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
