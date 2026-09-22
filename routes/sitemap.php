<?php

use Illuminate\Support\Facades\Route;
use App\Models\StartupModel;
use App\Models\CompanyModel;

Route::get('sitemap.xml', function () {
    $urls = [];

    // Static pages
    $staticPages = [
        ['url' => route('front.home'), 'priority' => '1.00', 'changefreq' => 'daily'],
        ['url' => route('front.abt'), 'priority' => '0.80', 'changefreq' => 'monthly'],
        ['url' => route('front.terminal'), 'priority' => '0.80', 'changefreq' => 'weekly'],
        ['url' => route('front.cards.startup'), 'priority' => '0.90', 'changefreq' => 'daily'],
        ['url' => route('front.cards.primary'), 'priority' => '0.90', 'changefreq' => 'daily'],
        ['url' => route('front.cards.secondary'), 'priority' => '0.90', 'changefreq' => 'daily'],
        ['url' => route('front.cards.preipo'), 'priority' => '0.90', 'changefreq' => 'daily'],
        ['url' => route('front.team'), 'priority' => '0.60', 'changefreq' => 'monthly'],
        ['url' => route('front.contactus.get'), 'priority' => '0.70', 'changefreq' => 'monthly'],
        ['url' => route('front.disclaimer'), 'priority' => '0.30', 'changefreq' => 'yearly'],
        ['url' => route('front.privacypolicy'), 'priority' => '0.40', 'changefreq' => 'yearly'],
        ['url' => route('front.termsofuse'), 'priority' => '0.40', 'changefreq' => 'yearly'],
        ['url' => route('front.riskdisclouser'), 'priority' => '0.40', 'changefreq' => 'yearly'],
    ];

    $urls = array_merge($urls, $staticPages);

    // Dynamic company pages
    $companies = CompanyModel::where('is_deleted', 0)
        ->where('is_active', 1)
        ->select('uuid', 'updated_at')
        ->limit(10000)
        ->get();

    foreach ($companies as $company) {
        $urls[] = [
            'url' => route('front.company.detail', $company->uuid),
            'priority' => '0.75',
            'changefreq' => 'weekly',
            'lastmod' => $company->updated_at->toAtomString(),
        ];
    }

    // Dynamic startup pages
    $startups = StartupModel::where('is_deleted', 0)
        ->where('startup_status', 'active')
        ->select('uuid', 'updated_at')
        ->limit(5000)
        ->get();

    foreach ($startups as $startup) {
        $urls[] = [
            'url' => route('front.company.detail', $startup->uuid),
            'priority' => '0.70',
            'changefreq' => 'weekly',
            'lastmod' => $startup->updated_at->toAtomString(),
        ];
    }

    $sitemap = view('sitemaps.sitemap-index', ['urls' => $urls]);

    return response($sitemap, 200)
        ->header('Content-Type', 'application/xml')
        ->header('Cache-Control', 'public, max-age=3600');
})->name('sitemap.xml');
