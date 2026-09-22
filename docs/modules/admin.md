# Module: Admin

## Purpose

Back-office operations for ShuruUp: users, companies, transactions, KYC reviews, CMS, broadcasts, masters, system settings.

## Entry points

- Routes: `routes/web.php` → `Route::prefix('admin')->name('admin.')`
- Controllers: `app/Http/Controllers/Web/Admin/**`
- Views: `resources/views/admin/**`
- Middleware: session `admin` guard; `hasPermission:{permission string}`
- Auth: `Web\Admin\Auth\AuthenticatedSessionController`

## Responsibilities

- Partner CRUD by type (wealth manager, distributor, retailer, relation manager)
- Investor management, manual KYC / AIF review
- Primary / secondary / Pre-IPO transaction ops + document upload
- Company master (prices, OCR import, WhatsApp report PDFs)
- AI AutoWork (`/admin/ai-autowork`) — Company Ingest inbox + per-job AI guides
- Coupons, BSE holidays, seller master, portfolios
- Masters (geo, banks, sectors, industries, header tokens, …)
- CMS pages/media, WhatsApp + push broadcasts
- App version / build / global settings
- Manager / master-admin user management

## Important files

| Area | Path |
|------|------|
| Dashboard | `Web\Admin\Dashboard\DashboardController` |
| Investors | `Web\Admin\InvestorController` |
| Companies | `Web\Admin\CompanyController` |
| Pre-IPO tx | `Web\Admin\PreIpoTransactionController` |
| Primary tx | `Web\Admin\PrimaryTransactionController` |
| Secondary tx | `Web\Admin\SecondaryTransactionController` |
| Permissions MW | `AdminPermissionsMiddleware` |
| Theme | `app/Core/*`, `ThemeHelper` |

## Database / models

Heavy use of: `InvestorModel`, `PartnerModel`, `StartupModel`, `CompanyModel`, `PreIpoModel`, `PrimaryTransactionModel`, `SecondaryTransactionModel`, `DocumentsModel`, master_* models, report/message models.

## Business rules

- Permission strings in routes must match rights stored for admin users (`AdminRightsModel` / Spatie permission config — verify before renaming).
- Document uploads often trigger helper status transitions (Digio-related).
- Company share-price OCR and partner WhatsApp PDF sending are admin-only operational tools with side effects (queue jobs).
- Company list more-options **Share Prices** is a list/filter/delete modal for `company_share_price` history (AJAX). It is separate from sidebar **Update Share Price**.

## Common modification points

- New admin screen: controller + Blade view + `routes/web.php` + breadcrumb in `routes/breadcrumbs.php` + permission gate.
- Changing list filters: often DataTables (`app/DataTables`, yajra).

## Risks

- Large controllers; prefer targeted methods.
- Permission typos silently block routes.
- Export/Excel (`maatwebsite/excel`) and DomPDF paths for reports.

## Related docs

- [features/pre-ipo.md](../features/pre-ipo.md)
- [features/primary-transactions.md](../features/primary-transactions.md)
- [authentication/overview.md](../authentication/overview.md)
