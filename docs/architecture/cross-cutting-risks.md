# Cross-Cutting Risks

For AI agents and developers: high-impact coupling and “do not casually change” areas.

## Fat controllers

| File | Approx. size | Risk |
|------|--------------|------|
| `app/Http/Controllers/Api/V2/Investor/CommonController.php` | ~3k+ lines | Most V2 investor product logic |
| `app/Http/Controllers/Api/V1/Investor/CommonController.php` | ~1.8k lines | Primary/secondary/Pre-IPO/KYC still used by V1 and some V2 routes |
| `app/Http/Controllers/Web/Admin/InvestorController.php` | ~1.8k lines | Admin investor ops |
| `app/Http/Controllers/Web/Admin/CompanyController.php` | ~1.6k lines | Company CRUD, OCR price parse, WhatsApp PDF queue |

**Careful:** small edits can break mobile contracts. Prefer additive fields; avoid renaming without versioned migration.

## Status machines live in helpers + enums

- Primary: `PrimaryTransactionStatusEnum` + `PrimaryTransactionHelper`
- Secondary: `SecondaryTransactionHelper` + sell-request models
- Pre-IPO: `PreIpoTransactionHelper` (+ V2 status list methods), Digio document completion callbacks

Changing a status label/string without updating mobile UI and admin filters will desync clients.

## Digio document webhooks

`WebhookController` + `DigioHelper` drive document signing completion → helpers call `changeTransactionStatus`. Breaking Digio payload handling blocks primary/secondary/Pre-IPO progression.

## Dual API surfaces

Partner/business routes often call **investor** controller methods for buy/sell. Fixing “investor only” behavior may unexpectedly change partner apps.

## `company.type`

Enum `CompanyTypeEnum`: `unlisted` | `secondary`. Used to separate markets in business v2 Pre-IPO APIs. Documented in `docs/preipo-v2-unlisted-secondary-api-changes.md`. Do not mix types in list/home payloads.

## Settings provider boot

`SettingServiceProvider` queries `app_settings` at boot. Missing DB/table breaks artisan and HTTP.

## Header auth HTTP code

Invalid `headtoken` → HTTP **500**. Do not “fix” to 401 without coordinating all mobile clients.

## Secrets in root README

Root `README.md` historically contained example AWS keys. Prefer `.env` only; rotate if those keys were real.

## Commented schedules / routes

Large blocks of startup “raise” web routes and Pre-IPO reminder schedules are commented. Re-enabling without ops readiness can spam users or expose unfinished UI.

## Unknown / unclear (verify in code before assuming)

- Exact production WhatsApp provider contract (11za webhook) — see `WebhookController` + message report models.
- Full meaning of every Pre-IPO timer/reminder command (several disabled).
- Whether all V1 secondary payment-upload routes are intentionally deprecated (commented in `api.php`).
- Completeness of V2 business `primary` / `secondary` route groups (currently empty stubs in `api.php`).
