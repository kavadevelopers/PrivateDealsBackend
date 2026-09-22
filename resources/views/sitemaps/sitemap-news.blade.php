<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">
    @foreach($urls as $url)
    <url>
        <loc>{{ htmlspecialchars($url['url'], ENT_XML1) }}</loc>
        @if(isset($url['lastmod']))
        <lastmod>{{ $url['lastmod'] }}</lastmod>
        @else
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        @endif
        <changefreq>{{ $url['changefreq'] ?? 'weekly' }}</changefreq>
        <priority>{{ $url['priority'] ?? '0.50' }}</priority>
        @if(isset($url['publication_date']))
        <news:news>
            <news:publication>
                <news:name>{{ CommonHelper::appSettings('app_name') }}</news:name>
                <news:language>en</news:language>
            </news:publication>
            <news:publication_date>{{ $url['publication_date'] }}</news:publication_date>
            <news:title>{{ Str::limit($url['title'] ?? 'Investment Opportunity', 120) }}</news:title>
        </news:news>
        @endif
    </url>
    @endforeach
</urlset>