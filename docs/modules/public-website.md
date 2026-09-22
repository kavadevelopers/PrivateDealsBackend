# Module: Public Website

## Purpose

Marketing site and content: home, about, product cards (startup/primary/secondary/private equity), company detail by slug, contact, legal pages, download, CML steps, inquiry / beta testing.

## Entry points

- `routes/web.php` `front.*` group
- Controllers: `Web\Front\WebsiteController`, `HomeController`, `PagesController`
- SEO: `SeoHelper`, `SeoMetaHelper`, `SeoUrlHelper`, `EnsureSeoMetaTags` middleware
- Sitemaps: `SitemapController`, `routes/sitemap.php` (if used)

## Features

- Public company pages (`company/{slugOrUuid}`)
- Contact form → `CmsContactModel` / notifications (`ContactUsNotificationJob`)
- Inquiry verification codes
- Dynamic URLs / share links may involve `DynamicUrlModel`, `DynamicUrlController`

## Dependencies

- Company + news content from admin CMS
- Global settings via `SettingServiceProvider` view share

## Risks

- Company `slug` is set from admin company create/update/import (`AdminHelper::companySlug`). Bulk/backfill still via `seo:generate-slugs` — changing existing slug values breaks public URLs and sitemaps.
- Maintenance mode middleware can hide the site.

## Related

- [features/companies-pricing.md](../features/companies-pricing.md)
- [modules/admin.md](admin.md) (CMS)
