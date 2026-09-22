<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class SeoMetaHelper
{
    /**
     * Generate SEO meta data for a company/startup
     * 
     * @param object $entity Company or Startup model instance
     * @return array
     */
    public static function getEntityMetaData($entity): array
    {
        $name = $entity->brand_name ?? $entity->company_name ?? $entity->name;
        // Use 'about' for companies, fall back to other fields
        $description = Str::limit($entity->about ?? $entity->description ?? $entity->tagline ?? '', 155);
        $keywords = $entity->keywords ?? $entity->industry ?? 'investment';

        if ($entity->sector) {
            $keywords .= ', ' . ($entity->sector->name ?? $entity->sector);
        }

        $keywords .= ', equity investment, startup, India';

        // Get logo - handle URL paths
        $logo = $entity->logo ?? $entity->featured_image ?? null;
        if ($logo && !str_starts_with($logo, 'http')) {
            $logo = asset('storage/' . $logo);
        }

        return [
            'title' => $name . ' - Investment Opportunity',
            'metaDescription' => $description ?: "Invest in {$name} through PrivateDeals. Access exclusive equity and pre-IPO opportunities.",
            'metaKeywords' => Str::limit($keywords, 200),
            'ogImage' => $logo ?? asset('core/images/default-company.png'),
        ];
    }

    /**
     * Generate SEO data with slug and UUID for backward compatibility
     */
    public static function getEntityUrlData($entity): array
    {
        // For companies, use slug; for startups, use url_slug
        $slug = $entity->slug ?? $entity->url_slug ?? Str::slug($entity->brand_name ?? $entity->company_name ?? $entity->name);

        return [
            'slug' => $slug,
            'uuid' => $entity->uuid,
            'url' => route('front.company.detail', [$slug]),
        ];
    }

    /**
     * Get page-specific meta description
     */
    public static function getPageMetaData(string $pageName): array
    {
        $data = [
            'startup' => [
                'metaDescription' => 'Invest in India\'s most promising startups. Access early-stage companies with high growth potential.',
                'metaKeywords' => 'startup investment, early-stage companies, venture, growth potential, India',
            ],
            'primary' => [
                'metaDescription' => 'Invest in primary market offerings. Access new equity from established companies and startups.',
                'metaKeywords' => 'primary market, new offerings, equity, IPO, established companies',
            ],
            'secondary' => [
                'metaDescription' => 'Trade pre-IPO and unlisted company shares. Access India\'s most active secondary market.',
                'metaKeywords' => 'secondary market, pre-IPO trading, unlisted shares, equity trading',
            ],
            'preipo' => [
                'metaDescription' => 'Invest in companies before their IPO. Verified pre-IPO opportunities with high returns potential.',
                'metaKeywords' => 'pre-IPO, IPO investment, unlisted companies, equity opportunity',
            ],
        ];

        return $data[$pageName] ?? [];
    }
}
