<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($categories as $category)
    <url>
        <loc>{{ url('/category/' . urlencode($category->name)) }}</loc>
        <lastmod>{{ \Carbon\Carbon::parse($category->updated_at)->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.6</priority>
    </url>
@endforeach
</urlset>