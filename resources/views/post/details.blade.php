@extends('layouts.app')
@section('title', $post->title)

@push('css')
    <meta property="og:url" content="{{ request()->url() }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $post->title }}" />
    <meta property="og:description" content="{{ Str::limit(strip_tags($post->description), 150) }}" />
    <meta property="og:image" content="{{ asset('storage/' . $post->thumbnail) }}" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $post->title }}">
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($post->description), 150) }}">
    <meta name="twitter:image" content="{{ asset('storage/' . $post->thumbnail) }}">

    <!-- ShareThis BEGIN -->
        <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=690cc0de38de9793e85fcc81&product=sop' async='async'></script>
    <!-- ShareThis END -->

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

        .like-info{
            white-space: nowrap;
        }
    </style>
@endpush

@section('main')
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
                        <div class="d-flex justify-content-between py-4" style="flex-wrap: nowrap">
                            <p class="like-info" >
                                <i class="fa fa-eye"></i>0 Views
                            </p>
                            <div class="w-100">
                                <div class="sharethis-inline-share-buttons"
                                    data-url="{{ request()->url() }}"
                                    data-image="{{ asset('storage/' . $post->thumbnail) }}"
                                    data-title="{{ $post->title }}"
                                    data-description="{{ Str::limit(strip_tags($post->description), 150) }}"
                                ></div>
                            </div>

                            
                        </div>
                    </div>

                    {{-- Comments Section (static placeholder for now) --}}
                    <div class="comments-area mt-0">
                        <h5>No Comments Yet</h5>
                    </div>

                    {{-- Comment Form --}}
                    <div class="comment-form mt-0">
                      <h4><i class="fa fa-comment"></i> Add Comment</h4>
                        <form class="form-contact comment_form" action="{{route('coming-soon')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea 
                                            class="form-control w-100 ps-5" 
                                            name="comment" 
                                            id="comment" 
                                            rows="4" 
                                            placeholder="Write Your Comment"
                                            aria-label="Write Your Comment"
                                            required
                                        ></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="button button-contactForm btn_1 boxed-btn w-100">
                                    <i class="fa fa-paper-plane"></i> Comment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="col-lg-4">
                    <div class="blog_right_sidebar">

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
                            <h4 class="widget_title">Subscribe</h4>
                            <small>Receive similar posts <i class="fa fa-paper-plane"></i> </small>
                            <form action="{{route('coming-soon')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <input type="email" class="form-control" onfocus="this.placeholder=''"
                                        onblur="this.placeholder='Enter email'" placeholder='Enter email' required>
                                </div>
                                <button type="submit" class="button rounded-0 w-100 btn_1 boxed-btn primary-bg">
                                    <i class="fa fa-envelope"></i> Subscribe
                                </button>
                            </form>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Select all forms with .form-contact or newsletter_widget form
    const forms = document.querySelectorAll('.comment_form, .newsletter_widget form');

    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (!submitBtn) return;

            // Prevent double click
            if (submitBtn.disabled) return;

            // Disable button
            submitBtn.disabled = true;

            // Save original text & icon
            const originalText = submitBtn.innerHTML;

            // Replace with loading state
            submitBtn.innerHTML = `
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                Please Wait...
            `;

            // Optional: Re-enable after 10s (fallback if redirect fails)
            setTimeout(() => {
                if (submitBtn.disabled) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            }, 4000);
        });
    });
});
</script>
@endpush