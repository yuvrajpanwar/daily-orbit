


<!-- ============================================================ -->
<!-- FILE 2: resources/views/sitemaps/posts.blade.php            -->
<!-- ============================================================ -->
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">
@foreach($posts as $post)
    <url>
        <loc>{{ url('/post/' . $post->slug) }}</loc>
        <lastmod>{{ \Carbon\Carbon::parse($post->updated_at)->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
@endforeach
</urlset>