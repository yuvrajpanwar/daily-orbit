@extends('layouts.app')
@section('title', $post->title)
@push('css')
    <meta property="og:url" content="{{ url('post/'.$post->slug) }}" />
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Hind:wght@400;500;700&family=Tiro+Devanagari+Hindi:wght@400;700&display=swap">
    <link rel="stylesheet" href="{{ asset('assets/css/post-details.min.css') }}">
    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=690cc0de38de9793e85fcc81&product=sop' async='async'></script>
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Article",
          "headline": "{{ $post->title }}",
          "image": "{{ asset('storage/' . $post->thumbnail) }}",
          "author": {
            "@type": "Person",
            "name": "{{ $post->author_name ?? 'Daily Orbit Team' }}"
          },
          "publisher": {
            "@type": "Organization",
            "name": "Daily Orbit",
            "logo": {
              "@type": "ImageObject",
              "url": "{{ asset('assets/img/logo/logo-circle.png') }}"
            }
          },
          "datePublished": "{{ \Carbon\Carbon::parse($post->time)->toIso8601String() }}",
          "dateModified": "{{ $post->updated_at->toIso8601String() }}",
          "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "{{ url()->current() }}"
          },
          "description": "{{ Str::limit(strip_tags($post->description), 200) }}"
        }
    </script>
@endpush

@section('main')
    <section class="blog_area single-post-area my-4">
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
                                    data-url="{{ url('post/'.$post->slug) }}"
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