<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Homepage -->
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    <!-- Pages Index (if any specific index exist, e.g. /berita, /agenda) -->
    <url>
        <loc>{{ url('/berita') }}</loc>
        <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ url('/agenda') }}</loc>
        <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>

    <!-- Posts -->
    @foreach($posts as $post)
    <url>
        <loc>{{ url('/' . $post->slug) }}</loc>
        <lastmod>{{ $post->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach

    <!-- Pages -->
    @foreach($pages as $page)
    <url>
        <loc>{{ url('/' . $page->slug) }}</loc>
        <lastmod>{{ $page->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.9</priority>
    </url>
    @endforeach

    <!-- Categories -->
    @foreach($categories as $cat)
    <url>
        <loc>{{ url('/category/' . $cat->slug) }}</loc>
        <lastmod>{{ $cat->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.6</priority>
    </url>
    @endforeach

    <!-- Events -->
    @foreach($events as $event)
    <url>
        <loc>{{ url('/agenda/' . $event->slug) }}</loc>
        <lastmod>{{ $event->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
    @endforeach
</urlset>
