@extends('layouts.app')
@section('title', $post->title)
@section('main')
    <link
        href="https://fonts.googleapis.com/css2?family=Hind:wght@400;500;700&family=Tiro+Devanagari+Hindi:wght@400;700&display=swap"
        rel="stylesheet">

    <style>
        .blog_area {
            font-family: 'Mangal', sans-serif;
            font-size: 18px;
            line-height: 1.9;
            color: #222;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Mangal', sans-serif;
            font-weight: 700;
            color: #111;
        }

        h2 {
            font-size: 1.9rem !important;
            line-height: 1.3;
        }

        h1 {
            font-size: 2rem !important;
            line-height: 1.3;
            font-weight: bold !important;
        }

        .blog_area .ul {
            font-family: 'Mangal', sans-serif;
        }

        .blog_details img{
            max-width: 95%;
            margin: auto;
            display: block;
        }

        .blog_area p {
            font-family: 'Mangal', sans-serif;
            font-size: 18px !important;
            line-height: 1.9;
            font-weight: 400;
            color: #222;
        }
    </style>

    <section class="blog_area single-post-area m-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 posts-list">
                    <div class="single-post">
                        <h1>{{ $post->title }}</h1>
                        <div class="feature-img">
                            <img class="img-fluid" src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}">
                        </div>

                        <div class="blog_details">


                            <ul class="blog-info-link mt-3 mb-4">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-user"></i>
                                        {{ $post->author_name ?? 'Unknown Author' }}
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-folder"></i>
                                        {{ $post->category_name ?? 'Uncategorized' }}
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-calendar"></i>
                                        {{ \Carbon\Carbon::parse($post->time)->format('M d, Y') }}
                                    </a>
                                </li>
                            </ul>

                            {{-- Description is stored as HTML so render safely --}}
                            <div class="post-content">
                                {!! $post->description !!}
                            </div>
                        </div>
                    </div>

                    {{-- Optional: navigation between posts --}}
                    <div class="navigation-top">
                        <div class="d-sm-flex justify-content-between text-center">
                            <p class="like-info">
                                <span class="align-middle"><i class="fa fa-heart"></i></span>
                                0 people like this
                            </p>

                            <ul class="social-icons">
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
                            </ul>
                        </div>
                    </div>

                    {{-- Author Info --}}
                    <div class="blog-author mt-5">
                        <div class="media align-items-center">
                            <img src="{{ asset('assets/img/blog/author.png') }}" alt="Author">
                            <div class="media-body">
                                <h4>{{ $post->author_name ?? 'Admin' }}</h4>
                                <p>Posts by this author coming soon...</p>
                            </div>
                        </div>
                    </div>

                    {{-- Comments Section (static placeholder for now) --}}
                    <div class="comments-area mt-5">
                        <h4>No Comments Yet</h4>
                        <p>Be the first to comment on this post.</p>
                    </div>

                    {{-- Comment Form --}}
                    <div class="comment-form mt-4">
                        <h4>Leave a Reply</h4>
                        <form class="form-contact comment_form" action="#" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea class="form-control w-100" name="comment" id="comment" cols="30" rows="9"
                                            placeholder="Write Comment"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input class="form-control" name="name" type="text" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input class="form-control" name="email" type="email" placeholder="Email">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="button button-contactForm btn_1 boxed-btn">
                                    Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="col-lg-4">
                    <div class="blog_right_sidebar">
                        {{-- Search Widget --}}
                        <aside class="single_sidebar_widget search_widget">
                            <form action="" method="GET">
                                <div class="input-group mb-3">
                                    <input type="text" name="query" class="form-control" placeholder="Search Keyword"
                                        onfocus="this.placeholder=''" onblur="this.placeholder='Search Keyword'">
                                    <div class="input-group-append">
                                        <button class="btns" type="submit">
                                            <i class="ti-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <button class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn"
                                    type="submit">Search</button>
                            </form>
                        </aside>

                        {{-- Categories Widget --}}
                        <aside class="single_sidebar_widget post_category_widget">
                            <h4 class="widget_title">Category</h4>
                            <ul class="list cat-list">
                                <li>
                                    <a href="#" class="d-flex">
                                        <p>{{ $post->category_name }}</p>
                                        {{-- Optionally show number of posts per category --}}
                                    </a>
                                </li>
                            </ul>
                        </aside>

                        {{-- Newsletter Widget --}}
                        <aside class="single_sidebar_widget newsletter_widget">
                            <h4 class="widget_title">Newsletter</h4>
                            <form action="#">
                                <div class="form-group">
                                    <input type="email" class="form-control" onfocus="this.placeholder=''"
                                        onblur="this.placeholder='Enter email'" placeholder='Enter email' required>
                                </div>
                                <button class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn"
                                    type="submit">Subscribe</button>
                            </form>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
