# Documentation Plan (Approved)

Approved for implementation. This records the analysis that produced the `docs/` tree.

## 1. Project understanding

ShuruUp V4 is a Laravel 11 private-markets investment platform: Pre-IPO/unlisted equity, startup primary fundraising, secondary share transfers, multi-actor portals (Admin, Investor, Partner, Startup), mobile APIs (v1/v2), and a public marketing site.

## 2. Detected architecture

Monolith: Blade/Livewire web + Sanctum REST APIs + database queue/cache/session + scheduled Artisan commands. Business logic concentrated in large controllers and Helpers; few Services; no Events/Listeners tree.

## 3. Major modules

Admin, Investor, Partner/Business, Startup, Public website, Shared helpers/services/jobs.

## 4. Major features

Pre-IPO, primary transactions, secondary market, KYC/demat, portfolio, companies/pricing/news, notifications, coupons/referrals, Calendly consultancy.

## 5. Important workflows

Investor onboarding; Pre-IPO buy/sell; primary investment status chain; secondary trade (ROFR/escrow/receipts).

## 6. Database overview

~136 models, ~363 migrations, MySQL, singular table names common (`investor`, `company`, `pre_ipo_transaction`, …).

## 7. API overview

`headtoken` + Sanctum; `/api/v1` and `/api/v2`; webhooks Digio/WhatsApp/Calendly; third-party sandbox.

## 8. Authentication

Multi-guard session + Sanctum; admin `hasPermission`; MPIN; Google V2 login.

## 9. Integrations

Digio, WhatsApp, FCM, Calendly, OCR.Space, AWS S3, Google, Spatie backup/permission, Telescope.

## 10. Configuration

`.env` + `app_settings` via `SettingServiceProvider` (boot dependency).

## 11–13. Proposed structure

Implemented under `docs/` as indexed in [README.md](README.md).

## 14. Maintenance

[maintenance/living-docs-rules.md](maintenance/living-docs-rules.md).

## 15. Unclear areas (documented as unknowns)

Startup front `/raise` commented routes; disabled Pre-IPO schedules; empty V2 business primary/secondary stubs; WhatsApp provider contract details; some deprecated secondary payment routes.

## 16. High-risk rules to preserve

Status enums/helpers; Digio webhooks; shared investor/partner methods; `company.type`; headtoken HTTP 500 behavior; KYC gates.

## 17. Info still useful from humans (optional)

Production Digio/WhatsApp credential locations; which mobile app versions are still on V1-only; whether startup self-serve web is intentionally offline.
