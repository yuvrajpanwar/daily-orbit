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
    <style>
    .hover-bg-light {
        transition: background-color 0.2s ease;
    }
    .hover-bg-light:hover {
        background-color: #f8f9fa !important;
    }
    .transition {
        transition: all 0.2s ease;
    }
</style>

<style>
    .similar-shimmer-item {
        display: flex;
        gap: 12px;
        align-items: center;
        animation: fadeIn 0.6s ease-out forwards;
        opacity: 0;
    }
    .similar-shimmer-item:nth-child(1) { animation-delay: 0.1s; }
    .similar-shimmer-item:nth-child(2) { animation-delay: 0.2s; }
    .similar-shimmer-item:nth-child(3) { animation-delay: 0.3s; }
    .similar-shimmer-item:nth-child(4) { animation-delay: 0.4s; }
    .similar-shimmer-item:nth-child(5) { animation-delay: 0.5s; }

    .shimmer-img {
        width: 100px;
        height: 80px;
        border-radius: 8px;
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
        width: 50%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6), transparent);
        animation: shine 1.8s ease-in-out infinite;
    }

    .shimmer-text { flex: 1; }
    .shimmer-line {
        height: 14px;
        border-radius: 7px;
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.8s ease-in-out infinite;
        margin: 6px 0;
    }
    .shimmer-line.title { width: 80%; height: 16px; }
    .shimmer-line.meta  { width: 55%; height: 12px; }

    @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
    @keyframes shine   { 0% { left: -150%; } 100% { left: 150%; } }
    @keyframes fadeIn  { to { opacity: 1; } }

    /* Real item fade-in */
    #similar-content li {
        animation: fadeInContent 0.5s ease-out forwards;
        opacity: 0;
        transform: translateY(5px);
    }
    #similar-content li:nth-child(1) { animation-delay: 0.1s; }
    #similar-content li:nth-child(2) { animation-delay: 0.2s; }
    #similar-content li:nth-child(3) { animation-delay: 0.3s; }
    #similar-content li:nth-child(4) { animation-delay: 0.4s; }
    #similar-content li:nth-child(5) { animation-delay: 0.5s; }

    @keyframes fadeInContent {
        to { opacity: 1; transform: translateY(0); }
    }

    /* Real image */
    .similar-real-img {
        width: 100px; height: 80px; object-fit: cover; border-radius: 8px;
        transition: transform .3s ease;
    }
    .similar-real-img:hover { transform: scale(1.05); }

    .similar-real-title {
        font-size: 14px; line-height: 1.3; font-weight: 600; margin: 0;
        color: #1a1a1a;
    }
    .similar-real-title a { color: inherit; text-decoration: none; }
    .similar-real-title a:hover { color: #ff4757; }

    .similar-real-meta { font-size: 12px; color: #666; }
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
                                <i class="fa fa-eye"></i>{{$post->total_views}} Views
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

                        {{-- Categories similar post Widget --}}
                        {{-- <aside class="single_sidebar_widget post_category_widget">
                            <h4 class="widget_title">Similar Posts</h4>
                            <ul class="list cat-list">
                                @forelse($similarPosts as $similar)
                                    <li>
                                        <a href="{{ route('post.details', $similar->slug) }}" 
                                        class="d-flex align-items-center p-2 rounded hover-bg-light transition">
                                            <div class="me-3">
                                                <img src="{{ asset('storage/' . $similar->thumbnail) }}" 
                                                    alt="{{ $similar->title }}"
                                                    class="rounded"
                                                    style="width: 100px; height: 80px; object-fit: cover;">
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="mb-1 fw-bold small text-dark" style="line-height: 1.3;">
                                                    {{ $similar->title }}
                                                </p>
                                                <small class="text-muted">
                                                    <i class="fa fa-user"></i> {{ $similar->author_name }}
                                                </small>
                                            </div>
                                        </a>
                                    </li>
                                @empty
                                    <li class="p-3 text-center text-muted small">
                                        No similar posts available.
                                    </li>
                                @endforelse
                            </ul>
                        </aside> --}}

                        {{-- Similar Posts Widget (AJAX + Shimmer) --}}
                        <aside class="single_sidebar_widget post_category_widget">
                            <h4 class="widget_title">Similar Posts</h4>

                            {{-- Shimmer Skeleton --}}
                            <div id="similar-loading">
                                @for($i = 0; $i < 5; $i++)
                                    <div class="similar-shimmer-item mb-3">
                                        <div class="shimmer-img"></div>
                                        <div class="shimmer-text">
                                            <div class="shimmer-line title"></div>
                                            <div class="shimmer-line meta"></div>
                                        </div>
                                    </div>
                                @endfor
                            </div>

                            {{-- Real Content (hidden initially) --}}
                            <ul class="list cat-list" id="similar-content" style="display:none;"></ul>
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

<script>
$(document).ready(function() {
    const slug = "{{ $post->slug }}"; // from current post

    $.ajax({
        url: '{{ route("post.similar.ajax", ":slug") }}'.replace(':slug', slug),
        method: 'GET',
        cache: true,
        success: function(posts) {
            let html = '';
            posts.forEach(function(p) {
                html += `
                    <li>
                        <a href="${p.post_url}" class="d-flex align-items-center p-2 rounded hover-bg-light transition">
                            <div class="me-3">
                                <img src="${p.image}" alt="${p.title}" class="similar-real-img">
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-1 similar-real-title">
                                    ${p.title}
                                </p>
                                <small class="similar-real-meta">
                                    <i class="fa fa-user"></i> ${p.author_name}
                                </small>
                            </div>
                        </a>
                    </li>`;
            });

            $('#similar-loading').fadeOut(300, function() {
                $('#similar-content').html(html).fadeIn(400);
            });
        },
        error: function() {
            $('#similar-loading').html('<p class="text-center text-muted small py-2">Failed to load.</p>');
        }
    });
});
</script>
@endpush