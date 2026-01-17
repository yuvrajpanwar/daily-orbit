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
            "headline": "{{ addslashes($post->title) }}",
            "image": "{{ asset('storage/' . $post->thumbnail) }}",
            "author": {
                "@type": "Person",
                "name": "{{ $post->author_name ?? 'Daily Orbit Team' }}"
            },
            "publisher": {
                "@type": "Organization",
                "name": "Daily Orbit",
                "logo": "{{ asset('assets/img/logo/logo-circle.png') }}"
            },
            "datePublished": "{{ $post->time ? \Carbon\Carbon::parse($post->time)->toIso8601String() : '' }}",
            "dateModified": "{{ $post->updated_at ? \Carbon\Carbon::parse($post->updated_at)->toIso8601String() : '' }}",
            "description": "{{ addslashes(Str::limit(strip_tags($post->description ?? ''), 200)) }}"
        }
    </script>
    <style>
        .google-btn:hover{
            color: white!important;
            -webkit-text-fill-color: whitesmoke!important;
        }
    </style>
    
        
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
                                    <a href="/author/{{ $post->author->id ?? 'Unknown Author' }}" style="text-decoration: underline !important;color:#ff2143">
                                        <i class="fa fa-user"></i>
                                        {{ $post->author->name ?? 'Unknown Author' }}
                                    </a>
                                </li>
                                <li>
                                    <a href="/category/{{ $post->category->name ?? '' }}" style="text-decoration: underline !important;color:#ff2143">
                                        <i class="fa fa-folder"></i>
                                        {{ $post->category->name ?? 'Uncategorized' }}
                                    </a>
                                </li>
                                <li>
                                    <small>
                                        <i class="fa fa-calendar"></i>
                                        {{ \Carbon\Carbon::parse($post->time)->format('M d, Y') }}
                                    </small>
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

                    <!-- Comments Section -->
                        <div class="comments-area mt-4 pb-0 pt-4 mb-0" id="comments-container">
                            <h4 class="mb-4">Comments (<span id="comments-total-count">{{ $post->comments_count ?? 0 }}</span>)</h4>

                            <div id="comments-list">
                                @if($post->comments->isNotEmpty())
                                    @foreach($post->comments->take(5) as $comment)
                                        @php
                                            $avatar = $comment->user->avatar ?? $comment->user->profile_picture ?? asset('assets/img/default-user-image.jpg');
                                            $time = $comment->created_at->format('h:i A d-m-Y');
                                        @endphp
                                        <x-comment-item :comment="$comment" :avatar="$avatar" :time="$time" />
                                    @endforeach
                                @else
                                    <p class="text-muted text-center pb-4" id="no-comments">No comments yet. Be the first to comment!</p>
                                @endif
                            </div>

                            @if($post->comments->count() > 5)
                                <div class="text-center">
                                    <button id="load-more-comments" 
                                            class="btn btn-outline-primary mb-3 mt-3"
                                            data-post-slug="{{ $post->slug }}"
                                            data-next-page="2">
                                        Load More Comments
                                    </button>
                                </div>
                            @endif
                        </div>

                        <!-- Comment Form (only for logged-in users) -->
                        <div class="comment-form mt-0 pt-0" id="comment-form-wrapper">
                            @auth
                                <form id="comment-form" class="form-contact comment_form">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group position-relative">
                                                <textarea class="form-control w-100 ps-5" 
                                                        name="comment" 
                                                        id="comment-textarea" 
                                                        rows="4"
                                                        placeholder="💬 Write Your Comment..." 
                                                        required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" id="submit-comment-btn" 
                                                class="button button-contactForm btn_1 boxed-btn w-100">
                                            <i class="fa fa-paper-plane"></i> Add Comment
                                        </button>
                                    </div>
                                </form>
                            @else
                                <!-- Guest version remains the same -->
                                <form id="guest-comment-form" class="form-contact" onsubmit="return false;">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group position-relative">
                                                <textarea class="form-control w-100 ps-5" id="comment-textarea-disabled" rows="4"
                                                        placeholder="💬 Write Your Comment..." required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="button button-contactForm btn_1 boxed-btn w-100" 
                                                data-bs-toggle="modal" data-bs-target="#loginRequiredModal">
                                            <i class="fa fa-lock me-2"></i> Login to Comment
                                        </button>
                                    </div>
                                </form>
                            @endauth
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
                            <form action="{{route('newsletter.subscribe')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" onfocus="this.placeholder=''"
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


        <div class="modal fade" id="loginRequiredModal" tabindex="-1" aria-labelledby="loginRequiredModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md"> <!-- ← changed from modal-lg to modal-md -->
                <div class="modal-content login-card border-0 shadow rounded-3 overflow-hidden">
                    
                    <!-- Header - smaller -->
                    <div class="modal-header bg-gradient-danger text-white border-0 py-3 px-4">
                        <h5 class="modal-title fs-5 fw-bold" id="loginRequiredModalLabel" style="color: #ff2143!important;">
                            Login to Comment
                        </h5>
                        <button type="button" class="btn-close btn-sm" style="color: #ff2143" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Body - more compact padding -->
                    <div class="modal-body p-4">

                        <!-- Google button - smaller -->
                        <div class="mb-3">
                            <a href="{{ route('google.login') }}" class="btn google-btn w-100 d-flex align-items-center justify-content-center gap-2 py-2 fs-6">
                                <i class="fab fa-google"></i>
                                Continue with Google
                            </a>
                        </div>

                        <div class="text-center mb-3">
                            <small class="text-muted">or</small>
                        </div>

                        <form method="POST" action="{{ route('login') }}" class="login-form">
                            @csrf

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="modal_email" class="form-label small fw-semibold mb-1">Email</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text"><i class="fas fa-envelope fa-xs"></i></span>
                                    <input type="email" class="form-control form-control-sm" id="modal_email" name="email"
                                        placeholder="your@email.com" required >
                                </div>
                                @error('email') <div class="invalid-feedback d-block small">{{ $message }}</div> @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="modal_password" class="form-label small fw-semibold mb-1">Password</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text"><i class="fas fa-lock fa-xs"></i></span>
                                    <input type="password" class="form-control form-control-sm" id="modal_password" name="password"
                                        placeholder="••••••" required>
                                    <button class="btn btn-outline-secondary btn-sm password-toggle" type="button" id="toggleModalPassword">
                                        <i class="fas fa-eye-slash fa-xs"></i>
                                    </button>
                                </div>
                                @error('password') <div class="invalid-feedback d-block small">{{ $message }}</div> @enderror
                            </div>

                            <!-- Remember & Forgot -->
                            <div class="d-flex justify-content-between align-items-center mb-3 small">
                                <div class="form-check">
                                    <input class="form-check-input form-check-sm" type="checkbox" name="remember" id="rememberModal">
                                    <label class="form-check-label" for="rememberModal">Remember me</label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-danger text-decoration-none small">
                                        Forgot Password?
                                    </a>
                                @endif
                            </div>

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-danger btn-sm w-100 d-flex align-items-center justify-content-center gap-2 py-2">
                                <span>Login</span>
                                <i class="fas fa-arrow-right fa-xs"></i>
                            </button>
                        </form>

                        <!-- Register link -->
                        <div class="text-center mt-3 small">
                            No account? 
                            <a href="{{ route('register') }}" class="text-danger fw-medium text-decoration-none">Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Password toggle script for modal -->
        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const toggleModalPassword = document.getElementById('toggleModalPassword');
                    if (toggleModalPassword) {
                        toggleModalPassword.addEventListener('click', function () {
                            const passwordInput = document.getElementById('modal_password');
                            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                            passwordInput.setAttribute('type', type);
                            this.querySelector('i').classList.toggle('fa-eye-slash');
                            this.querySelector('i').classList.toggle('fa-eye');
                        });
                    }
                });
            </script>
                
        @endpush

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
    $('#comment-textarea-disabled').on('click', function(){
        $('#loginRequiredModal').modal('show');
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

    // Submit comment via AJAX
    const commentForm = document.getElementById('comment-form');
    if (commentForm) {
        commentForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const btn = document.getElementById('submit-comment-btn');
            const textarea = document.getElementById('comment-textarea');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Sending...';

            try {
                const formData = new FormData(commentForm);
                const response = await fetch(`/posts/{{ $post->slug }}/comments`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Append new comment at the top
                    const list = document.getElementById('comments-list');
                    const noComments = document.getElementById('no-comments');

                    if (noComments) noComments.remove();

                    list.insertAdjacentHTML('afterbegin', data.comment.html);

                    textarea.value = '';

                    // ────────────────────────────────────────────────
                    // Increment visible comments count
                    const countElement = document.getElementById('comments-total-count');
                    if (countElement) {
                        let currentCount = parseInt(countElement.textContent.trim(), 10) || 0;
                        countElement.textContent = currentCount + 1;
                    }
                    // ────────────────────────────────────────────────

                    // Optional: scroll to new comment
                    document.querySelector('.comment-item')?.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'center' 
                    });
                } else {
                    alert(data.message || 'Something went wrong');
                }
            } catch (err) {
                console.error(err);
                alert('Error submitting comment');
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa fa-paper-plane"></i> Add Comment';
            }
        });
    }

    // Load more comments
    const loadMoreBtn = document.getElementById('load-more-comments');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', async function () {
            const slug = this.dataset.postSlug;
            const page = this.dataset.nextPage;

            this.disabled = true;
            this.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';

            try {
                const response = await fetch(`/posts/${slug}/comments?page=${page}`, {
                    headers: { 'Accept': 'application/json' }
                });

                const data = await response.json();

                if (data.comments) {
                    document.getElementById('comments-list').insertAdjacentHTML('beforeend', data.comments);

                    if (data.has_more) {
                        this.dataset.nextPage = data.next_page;
                    } else {
                        this.remove();
                    }
                }
            } catch (err) {
                console.error(err);
            } finally {
                this.disabled = false;
                this.innerHTML = 'Load More Comments';
            }
        });
    }
});
</script>

@endpush