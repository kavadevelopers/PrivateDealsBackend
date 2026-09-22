<?php

namespace App\Http\Controllers;

use App\Models\StartupModel;
use App\Models\CompanyModel;
use Illuminate\Routing\Controller as BaseController;

class SitemapController extends BaseController
{
    /**
     * Generate main XML sitemap
     */
    public function index()
    {
        $urls = [];

        // Static pages with proper priority and changefreq
        $staticPages = [
            [
                'url' => route('front.home'),
                'priority' => '1.00',
                'changefreq' => 'daily',
                'lastmod' => now()->toAtomString()
            ],
            [
                'url' => route('front.abt'),
                'priority' => '0.80',
                'changefreq' => 'monthly',
                'lastmod' => now()->toAtomString()
            ],
            [
                'url' => route('front.terminal'),
                'priority' => '0.80',
                'changefreq' => 'weekly',
                'lastmod' => now()->toAtomString()
            ],
            [
                'url' => route('front.cards.startup'),
                'priority' => '0.90',
                'changefreq' => 'daily',
                'lastmod' => now()->toAtomString()
            ],
            [
                'url' => route('front.cards.primary'),
                'priority' => '0.90',
                'changefreq' => 'daily',
                'lastmod' => now()->toAtomString()
            ],
            [
                'url' => route('front.cards.secondary'),
                'priority' => '0.90',
                'changefreq' => 'daily',
                'lastmod' => now()->toAtomString()
            ],
            [
                'url' => route('front.cards.preipo'),
                'priority' => '0.90',
                'changefreq' => 'daily',
                'lastmod' => now()->toAtomString()
            ],
            [
                'url' => route('front.team'),
                'priority' => '0.60',
                'changefreq' => 'monthly',
                'lastmod' => now()->toAtomString()
            ],
            [
                'url' => route('front.contactus.get'),
                'priority' => '0.70',
                'changefreq' => 'monthly',
                'lastmod' => now()->toAtomString()
            ],
            [
                'url' => route('front.disclaimer'),
                'priority' => '0.30',
                'changefreq' => 'yearly',
                'lastmod' => now()->toAtomString()
            ],
            [
                'url' => route('front.privacypolicy'),
                'priority' => '0.40',
                'changefreq' => 'yearly',
                'lastmod' => now()->toAtomString()
            ],
            [
                'url' => route('front.termsofuse'),
                'priority' => '0.40',
                'changefreq' => 'yearly',
                'lastmod' => now()->toAtomString()
            ],
            [
                'url' => route('front.riskdisclouser'),
                'priority' => '0.40',
                'changefreq' => 'yearly',
                'lastmod' => now()->toAtomString()
            ],
        ];

        $urls = array_merge($urls, $staticPages);

        // Dynamic company pages (limit to 10,000 URLs per sitemap)
        $companies = CompanyModel::where('is_deleted', 0)
            ->where('is_active', 1)
            ->select('uuid', 'updated_at')
            ->orderBy('updated_at', 'desc')
            ->limit(5000)
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
            ->orderBy('updated_at', 'desc')
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
    }

    /**
     * Generate news sitemap for recent articles/updates
     */
    public function news()
    {
        $urls = [];

        // Get recent company updates (if you have this model)
        $news = StartupModel::where('is_deleted', 0)
            ->where('startup_status', 'active')
            ->select('uuid', 'name', 'updated_at')
            ->orderBy('updated_at', 'desc')
            ->limit(1000)
            ->get();

        foreach ($news as $item) {
            $urls[] = [
                'url' => route('front.company.detail', $item->uuid),
                'priority' => '0.80',
                'changefreq' => 'daily',
                'lastmod' => $item->updated_at->toAtomString(),
                'publication_date' => $item->updated_at->format('Y-m-d'),
            ];
        }

        $sitemap = view('sitemaps.sitemap-news', ['urls' => $urls]);

        return response($sitemap, 200)
            ->header('Content-Type', 'application/xml')
            ->header('Cache-Control', 'public, max-age=3600');
    }
}
