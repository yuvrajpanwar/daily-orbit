@extends('layouts.app')

@section('title', $author->name . ' - Daily Orbit')

@push('css')
    <meta property="og:url" content="{{ request()->url() }}" />
    <meta property="og:type" content="profile" />
    <meta property="og:title" content="{{ $author->name }} - Daily Orbit" />
    <meta property="og:description" content="{{ Str::limit(strip_tags($author->about ?? ''), 160) }}" />
    <meta property="og:image" content="{{ $author->profile_picture ? asset('storage/' . $author->profile_picture) : asset('assets/img/default-avatar.png') }}" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $author->name }} - Daily Orbit">
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($author->about ?? ''), 160) }}">

    <style>
        .author-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 5rem 0 4rem;
            margin-bottom: 3rem;
            border-radius: 0 0 30px 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .author-avatar {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            object-fit: cover;
            border: 6px solid white;
            box-shadow: 0 8px 25px rgba(0,0,0,0.25);
        }

        .author-name {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .author-bio {
            font-size: 1.1rem;
            max-width: 720px;
            margin: 1.5rem auto 0;
            opacity: 0.95;
            line-height: 1.6;
        }

        /* === Card Styling === */
        .category-card {
            transition: transform .3s ease, box-shadow .3s ease;
            border-radius: 12px;
            overflow: hidden;
            height: 100%;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.12);
        }
        .category-img {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
        .card-body {
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
        }
        .card-title {
            font-size: 1.1rem;
            font-weight: 700;
            line-height: 1.4;
            margin-bottom: .5rem;
            color: #1a1a1a;
        }
        .card-title a {
            color: inherit;
            text-decoration: none;
        }
        .card-title a:hover {
            color: #ff4757;
        }
        .card-text {
            font-size: 0.9rem;
            color: #555;
            flex-grow: 1;
            margin-bottom: .75rem;
        }
        .card-meta {
            font-size: 0.8rem;
            color: #888;
        }
        .card-meta i {
            margin-right: 4px;
        }

        /* === Shimmer Skeleton === */
        .shimmer-card {
            background: #f6f7f8;
            border-radius: 12px;
            overflow: hidden;
            animation: fadeIn 0.6s ease-out forwards;
            opacity: 0;
        }
        .shimmer-card:nth-child(1) { animation-delay: 0.1s; }
        .shimmer-card:nth-child(2) { animation-delay: 0.2s; }
        .shimmer-card:nth-child(3) { animation-delay: 0.3s; }
        .shimmer-card:nth-child(4) { animation-delay: 0.4s; }

        .shimmer-img-category {
            width: 100%;
            height: 200px;
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.8s ease-in-out infinite;
        }
        .shimmer-line {
            height: 16px;
            margin: 8px 0;
            border-radius: 8px;
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.8s ease-in-out infinite;
        }
        .shimmer-line.title { width: 85%; height: 20px; }
        .shimmer-line.text  { width: 100%; height: 14px; }
        .shimmer-line.meta  { width: 60%; height: 12px; }

        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        @keyframes fadeIn {
            to { opacity: 1; }
        }

        .no-posts {
            grid-column: 1 / -1;
            text-align: center;
            padding: 3rem;
            color: #666;
            font-size: 1.1rem;
        }

        /* Loading Trigger */
        #load-more-trigger {
            padding: 2rem 0;
        }
    </style>
@endpush

@section('main')
    <section class="author-header text-center">
        <div class="container">
            @if($author->profile_picture)
                <img src="{{ asset('/uploads/authors/' . $author->profile_picture) }}" alt="{{ $author->name }}" class="author-avatar mb-4">
            @else
                <div class="author-avatar mb-4 d-flex align-items-center justify-content-center bg-white text-primary fs-1 fw-bold mx-auto">
                    {{ strtoupper(substr($author->name, 0, 1)) }}
                </div>
            @endif

            <h1 class="author-name">{{ $author->name }}</h1>

            @if($author->about)
                <div class="author-bio">
                    {!! nl2br(e($author->about)) !!}
                </div>
            @else
                <p class="author-bio">Passionate writer sharing insights on various topics.</p>
            @endif
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold">All Articles by {{ $author->name }}</h2>

            <!-- Shimmer Skeleton -->
            <div id="shimmer-container" class="row g-4">
                @for($i = 0; $i < 4; $i++)
                    <div class="col-lg-3 col-md-6">
                        <div class="shimmer-card">
                            <div class="shimmer-img-category"></div>
                            <div class="card-body p-4">
                                <div class="shimmer-line title"></div>
                                <div class="shimmer-line text"></div>
                                <div class="shimmer-line text"></div>
                                <div class="shimmer-line meta mt-3"></div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            <!-- Real Posts -->
            <div id="posts-container" class="row g-4" style="display: none;">
                @forelse($posts as $post)
                    <div class="col-lg-3 col-md-6 post-card">
                        <a href="{{ $post->post_url }}" class="text-decoration-none">
                            <article class="category-card h-100 d-block">
                                <img src="{{ $post->image }}" alt="{{ $post->title }}" class="category-img">
                                <div class="card-body">
                                    <h3 class="card-title mb-2">
                                        {{ $post->title }}
                                    </h3>
                                    <p class="card-text text-muted small">{{ $post->excerpt }}</p>
                                    <div class="card-meta text-muted small">
                                        <span><i class="fa fa-calendar"></i> {{ $post->date }}</span>
                                    </div>
                                </div>
                            </article>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="no-posts">
                            <p>No published articles yet.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Load more trigger -->
            <div id="load-more-trigger" class="text-center mt-5" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = $('#posts-container');
            const shimmer  = $('#shimmer-container');
            const trigger  = $('#load-more-trigger');
            let page = 1;
            let loading = false;
            let hasMore = true;

            const authorId = "{{ $author->id }}";

            // Show content after shimmer
            setTimeout(() => {
                shimmer.fadeOut(300, () => {
                    container.fadeIn(400);
                    if ({{ $posts->count() }} >= 5) {
                        trigger.show();
                    }
                });
            }, 800);

            // Infinite scroll
            $(window).on('scroll', function () {
                if (loading || !hasMore) return;

                if ($(window).scrollTop() + $(window).height() > $(document).height() - 800) {
                    loadMore();
                }
            });

            function loadMore() {
                loading = true;
                trigger.show();

                page++;

                $.ajax({
                    url: '{{ route("author.loadmore", ":id") }}'.replace(':id', authorId),
                    method: 'GET',
                    data: { page: page },
                    success: function (posts) {
                        if (posts.length === 0) {
                            hasMore = false;
                            trigger.hide();
                            return;
                        }

                        let html = '';
                        posts.forEach(p => {
                            html += `
                                <div class="col-lg-3 col-md-6 post-card">
                                    <a href="${p.post_url}" class="text-decoration-none">
                                        <article class="category-card h-100 d-block">
                                            <img src="${p.image}" alt="${p.title}" class="category-img">
                                            <div class="card-body">
                                                <h3 class="card-title mb-2">${p.title}</h3>
                                                <p class="card-text text-muted small">${p.excerpt}</p>
                                                <div class="card-meta text-muted small">
                                                    <span><i class="fa fa-calendar"></i> ${p.date}</span>
                                                </div>
                                            </div>
                                        </article>
                                    </a>
                                </div>`;
                        });

                        container.append(html);
                        trigger.hide();
                        loading = false;
                    },
                    error: function () {
                        trigger.hide();
                        loading = false;
                    }
                });
            }
        });
    </script>
@endpush