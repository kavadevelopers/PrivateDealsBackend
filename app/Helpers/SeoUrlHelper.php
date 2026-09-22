<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class SeoUrlHelper
{
    /**
     * Get the SEO-friendly URL for a company
     * 
     * @param object $entity Company or Startup model
     * @return string
     */
    public static function getCompanyUrl($entity): string
    {
        if ($entity->slug) {
            return route('front.company.detail', $entity->slug);
        }

        // Fallback to UUID if slug not generated yet
        return route('front.company.detail', $entity->uuid);
    }

    /**
     * Get display title for a company with proper SEO
     */
    public static function getCompanyTitle($entity): string
    {
        return $entity->brand_name ?? $entity->company_name ?? $entity->name;
    }

    /**
     * Generate canonical URL for current page
     */
    public static function getCanonicalUrl(): string
    {
        $request = request();
        $url = $request->url();

        // Remove tracking parameters from canonical
        $url = Str::before($url, '?');

        return $url;
    }

    /**
     * Check if URL uses UUID (old format)
     */
    public static function isUuidUrl(string $identifier): bool
    {
        return Str::isUuid($identifier);
    }

    /**
     * Get OG image URL with fallback
     */
    public static function getOgImage($entity, string $default = null): string
    {
        $image = $entity->logo ?? $entity->featured_image ?? $entity->banner;

        if ($image) {
            return asset($image);
        }

        return $default ?? asset('core/images/og-image.png');
    }

    /**
     * Truncate and sanitize meta description
     */
    public static function getSafeMetaDescription(string $description, int $length = 160): string
    {
        $description = strip_tags($description);
        $description = preg_replace('/\s+/', ' ', $description);
        $description = trim($description);

        return Str::limit($description, $length);
    }

    /**
     * Build breadcrumb structure for schema
     */
    public static function getBreadcrumbs($current = []): array
    {
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('front.home')],
        ];

        if (!empty($current)) {
            $breadcrumbs = array_merge($breadcrumbs, $current);
        }

        return $breadcrumbs;
    }
}
