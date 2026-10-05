<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<?php echo '<?xml-stylesheet type="text/xsl" href="' . asset('sitemap.xsl') . '"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @if($type == 'page')
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>{{ url('/blog') }}</loc>
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
    @endif

    @foreach($items as $item)
    <url>
        @if($type == 'post')
            <loc>{{ url('/' . $item->slug) }}</loc>
        @elseif($type == 'page')
            <loc>{{ url('/' . $item->slug) }}</loc>
        @elseif($type == 'category')
            <loc>{{ url('/category/' . $item->slug) }}</loc>
        @elseif($type == 'event')
            <loc>{{ url('/agenda/' . $item->slug) }}</loc>
        @endif
        <lastmod>{{ $item->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>{{ $type == 'page' ? 'monthly' : 'weekly' }}</changefreq>
        <priority>{{ $type == 'page' ? '0.8' : '0.7' }}</priority>
    </url>
    @endforeach
</urlset>
