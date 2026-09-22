<?php

namespace App\Helpers;

use App\Models\MasterWebsiteSocialmediaModel;
use Illuminate\Support\Str;

class SeoHelper
{
    /**
     * Generate meta tags for a page
     */
    public static function generateMetaTags($title, $description, $keywords = null, $image = null, $url = null)
    {
        $appName = CommonHelper::appSettings('app_name') ?? 'PrivateDeals';
        $fullTitle = $title ? "$title | $appName" : $appName;
        $description = $description ?? CommonHelper::appSettings('app_meta_description') ?? 'India\'s premier platform for startup investments, primary transactions, secondary market, and pre-IPO opportunities.';
        $image = $image ?? asset('core/images/og-image.png');
        $url = $url ?? request()->url();
        $keywords = $keywords ?? CommonHelper::appSettings('app_meta_keywords') ?? 'startup investment, pre-IPO, secondary market, primary market, equity investment';

        return [
            'title' => $fullTitle,
            'description' => Str::limit($description, 160),
            'keywords' => $keywords,
            'image' => $image,
            'url' => $url,
        ];
    }

    /**
     * Generate Schema.org JSON-LD structured data
     */
    public static function generateSchemaMarkup($type = 'Organization', $data = [])
    {
        $baseSchema = [
            '@context' => 'https://schema.org',
            '@type' => $type,
            'name' => CommonHelper::appSettings('app_name') ?? 'PrivateDeals',
            'url' => config('app.url'),
            'logo' => asset('core/images/logo.png'),
            'description' => CommonHelper::appSettings('app_meta_description'),
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'contactType' => 'Customer Service',
                'telephone' => CommonHelper::appSettings('branding_content_contact_mobile'),
                'email' => CommonHelper::appSettings('branding_content_contact_email'),
            ],
        ];

        // Add social profiles
        $socialProfiles = MasterWebsiteSocialmediaModel::where('is_deleted', 0)->pluck('link')->toArray();
        if ($socialProfiles) {
            $baseSchema['sameAs'] = $socialProfiles;
        }

        // Merge with additional data
        $schema = array_merge($baseSchema, $data);

        return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * Generate breadcrumb schema markup
     */
    public static function generateBreadcrumbSchema($breadcrumbs)
    {
        $items = [];
        foreach ($breadcrumbs as $index => $breadcrumb) {
            $items[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $breadcrumb['name'],
                'item' => $breadcrumb['url'] ?? null,
            ];
        }

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items,
        ];

        return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * Generate FAQPage schema markup
     */
    public static function generateFaqSchema($faqs)
    {
        $mainEntity = [];
        foreach ($faqs as $faq) {
            $mainEntity[] = [
                '@type' => 'Question',
                'name' => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['answer'],
                ],
            ];
        }

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $mainEntity,
        ];

        return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * Generate Article schema markup
     */
    public static function generateArticleSchema($title, $description, $image, $datePublished, $dateModified, $author = null)
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $title,
            'description' => $description,
            'image' => [$image],
            'datePublished' => $datePublished,
            'dateModified' => $dateModified,
            'author' => [
                '@type' => 'Organization',
                'name' => $author ?? CommonHelper::appSettings('app_name'),
            ],
        ];

        return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * Generate Product/Investment Opportunity schema
     */
    public static function generateInvestmentOpportunitySchema($startup)
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Investment',
            'name' => $startup->company_name ?? $startup->name,
            'description' => Str::limit($startup->description ?? '', 200),
            'image' => $startup->logo ?? asset('core/images/default-company.png'),
            'category' => $startup->industry ?? 'Investment Opportunity',
            'url' => route('front.company.detail', $startup->uuid),
        ];

        return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * Generate canonical URL
     */
    public static function getCanonicalUrl($url = null)
    {
        return $url ?? request()->url();
    }

    /**
     * Get robots meta tag content
     */
    public static function getRobotsContent($index = true, $follow = true, $snippet = true)
    {
        $content = [];
        $content[] = $index ? 'index' : 'noindex';
        $content[] = $follow ? 'follow' : 'nofollow';
        if (!$snippet) {
            $content[] = 'nosnippet';
        }
        return implode(', ', $content);
    }
}
