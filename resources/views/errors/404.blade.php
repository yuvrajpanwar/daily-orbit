@extends('layouts.app')

@section('title', 'Page Not Found — Daily Orbit')

@push('css')
<meta name="robots" content="noindex, nofollow">
<style>
    .error-404-section {
        min-height: 60vh;
        display: flex;
        align-items: center;
        padding: 60px 0;
    }
    .error-404-number {
        font-size: 120px;
        font-weight: 700;
        color: #ff2143;
        line-height: 1;
        text-shadow: 4px 4px 0px #ffe0e5;
    }
    .error-404-title {
        font-size: 28px;
        font-weight: 700;
        color: #2d2d2d;
        margin-bottom: 12px;
    }
    .error-404-subtitle {
        font-size: 15px;
        color: #777;
        margin-bottom: 28px;
        line-height: 1.7;
    }
    .error-search-form {
        display: flex;
        gap: 8px;
        margin-bottom: 28px;
    }
    .error-search-form input {
        flex: 1;
        padding: 10px 16px;
        border: 2px solid #eee;
        border-radius: 4px;
        font-size: 14px;
        outline: none;
        transition: border-color 0.2s;
    }
    .error-search-form input:focus {
        border-color: #ff2143;
    }
    .error-search-form button {
        background: #ff2143;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: background 0.2s;
    }
    .error-search-form button:hover {
        background: #d4002f;
    }
    .error-quick-links {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 28px;
    }
    .error-quick-links a {
        background: #f7f7f7;
        color: #444;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        text-decoration: none;
        border: 1px solid #eee;
        transition: all 0.2s;
    }
    .error-quick-links a:hover {
        background: #ff2143;
        color: white;
        border-color: #ff2143;
    }
    .error-home-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #ff2143;
        color: white !important;
        padding: 12px 28px;
        border-radius: 4px;
        font-size: 15px;
        font-weight: 600;
        text-decoration: none !important;
        transition: background 0.2s;
    }
    .error-home-btn:hover {
        background: #d4002f;
        color: white !important;
    }
    .error-404-image {
        text-align: center;
        opacity: 0.85;
    }
    .error-404-image img {
        max-width: 320px;
        width: 100%;
    }
    @media (max-width: 768px) {
        .error-404-number { font-size: 80px; }
        .error-404-title  { font-size: 22px; }
        .error-404-image  { margin-bottom: 32px; }
    }
</style>
@endpush

@section('main')
<section class="error-404-section">
    <div class="container">
        <div class="row align-items-center justify-content-center">

            {{-- Left: illustration --}}
            <div class="col-lg-5 col-md-6 error-404-image order-md-2 mb-4 mb-md-0">
                <div class="error-404-number text-center">404</div>
                <p class="text-center mt-2" style="color:#aaa; font-size:13px; letter-spacing:2px; text-transform:uppercase;">
                    Page Not Found
                </p>
            </div>

            {{-- Right: message + search --}}
            <div class="col-lg-6 col-md-6 order-md-1">
                <h1 class="error-404-title">Oops! This page doesn't exist.</h1>
                <p class="error-404-subtitle">
                    The page you're looking for may have been removed, renamed, or never existed.
                    Try searching for what you need or explore our categories below.
                </p>

                {{-- Search --}}
                <form class="error-search-form" action="{{ url('/') }}" method="GET">
                    <input type="text" name="q" placeholder="Search Daily Orbit...">
                    <button type="submit">
                        <i class="fa fa-search"></i> Search
                    </button>
                </form>

                {{-- Quick category links --}}
                <div class="error-quick-links">
                    <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                    <a href="{{ url('/category/Technology') }}">Technology</a>
                    <a href="{{ url('/category/Finance') }}">Finance</a>
                    <a href="{{ url('/category/Lifestyle') }}">Lifestyle</a>
                    <a href="{{ url('/category/Travel & Tourism') }}">Travel</a>
                    <a href="{{ url('/category/News') }}">News</a>
                    <a href="{{ url('/category/Sports') }}">Sports</a>
                </div>

                {{-- Home button --}}
                <a href="{{ url('/') }}" class="error-home-btn">
                    <i class="fa fa-arrow-left"></i> Back to Home
                </a>
            </div>

        </div>

        {{-- Recent posts below --}}
        <div class="row mt-5">
            <div class="col-12">
                <h4 style="font-weight:700; color:#2d2d2d; border-left: 4px solid #ff2143; padding-left:12px; margin-bottom:24px;">
                    You Might Like These
                </h4>
            </div>
            <div id="404-recent-posts" class="col-12">
                <div class="row" id="404-posts-grid">
                    {{-- Shimmer placeholders while loading --}}
                    @for($i = 0; $i < 3; $i++)
                    <div class="col-md-4 mb-4 shimmer-card-404">
                        <div style="background:#f0f0f0; height:180px; border-radius:6px; margin-bottom:10px;
                                    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
                                    background-size: 200% 100%; animation: shimmer404 1.4s infinite;">
                        </div>
                        <div style="background:#f0f0f0; height:16px; border-radius:4px; margin-bottom:8px; width:80%;
                                    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
                                    background-size: 200% 100%; animation: shimmer404 1.4s infinite;">
                        </div>
                        <div style="background:#f0f0f0; height:12px; border-radius:4px; width:50%;
                                    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
                                    background-size: 200% 100%; animation: shimmer404 1.4s infinite;">
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>

    </div>
</section>

@push('css')
<style>
    @keyframes shimmer404 {
        0%   { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
</style>
@endpush

@push('scripts')
<script>
    // Load recent posts via your existing API
    fetch('/most-recent-posts')
        .then(r => r.json())
        .then(posts => {
            let html = '';
            posts.forEach(p => {
                html += `
                <div class="col-md-4 mb-4">
                    <a href="${p.post_url}" style="text-decoration:none; color:inherit;">
                        <div style="border-radius:6px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,0.07); transition: transform 0.2s;"
                             onmouseover="this.style.transform='translateY(-4px)'"
                             onmouseout="this.style.transform='translateY(0)'">
                            <img src="${p.image}" alt="${p.title}"
                                 style="width:100%; height:180px; object-fit:cover;">
                            <div style="padding:14px;">
                                <p style="font-weight:600; font-size:14px; color:#2d2d2d; margin-bottom:6px; line-height:1.4;">
                                    ${p.title}
                                </p>
                                <small style="color:#aaa;">
                                    <i class="fa fa-clock-o"></i> ${p.time_ago}
                                </small>
                            </div>
                        </div>
                    </a>
                </div>`;
            });
            document.querySelector('.shimmer-card-404') && 
                document.querySelectorAll('.shimmer-card-404').forEach(el => el.remove());
            document.getElementById('404-posts-grid').innerHTML = html;
        })
        .catch(() => {
            document.getElementById('404-recent-posts').innerHTML = '';
        });
</script>
@endpush

@endsection