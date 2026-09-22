# Module: Partner / Business

## Purpose

Channel partners manage investors, view MIS/earnings, run primary/secondary/Pre-IPO activity on behalf of or alongside investors, and use the business mobile API.

## Partner types

`PartnerTypeEnum`:

- `wealthmanager` — Wealth Manager
- `distributor` — Distributor
- `retailer` — Retailer
- `relationmanager` — Relation Manager

Admin UI splits these under `/admin/partner/...`.

## Surfaces

| Surface | Entry |
|---------|--------|
| Web | `Web\Front\User\Partner\*`, partner auth controllers |
| API V1 | `/api/v1/business/*` → `Api\V1\Business\*` (+ reused investor methods) |
| API V2 | `/api/v2/business/*` → `Api\V2\Business\CommonController` |

## Auth

- Model: `PartnerModel` (`partner`)
- Guards: `partner` (session), `partner-api-guard` (Sanctum)

## Important capabilities (V1)

- Dashboard + Pre-IPO dashboard
- Primary/secondary transaction lists
- Channel partner CRUD
- Investor create/update under partner
- Earnings (investor / partner)
- Portfolio views
- Pending tasks, documents, notifications
- Pre-IPO buy/sell via investor controller methods

## Important capabilities (V2)

- Pre-IPO home (unlisted-oriented, capped lists)
- Secondary home (combined: one `all` list + news + sectors, `company.type=secondary`)
- Company list/detail with `company.type` awareness
- Startup list/detail
- Investor detail
- Pre-IPO transaction list
- Portfolio startup + pre-IPO (grouped by investor with totals)
- Empty route stubs for `primary` / `secondary` prefixes (not implemented yet)

## Important files

- `Api\V1\Business\CommonController`, `LoginController`, `CommonKycController`
- `Api\V2\Business\CommonController`
- `Api\V2\Business\PortfolioController`
- `Repositories\PartnerRepository`
- Admin: `Web\Admin\Partner\*`

## Dependencies

- Investor records owned/linked to partners
- Same transaction tables as investors
- WhatsApp company report jobs (`SendCompanyReportToPartnersJob`)

## Risks

- Reused investor endpoints: changing investor Pre-IPO buy also changes partner app behavior.
- V2 business APIs intentionally filter **unlisted** vs **secondary** — see `preipo-v2-unlisted-secondary-api-changes.md`.
- Hierarchy (RM / distributor / retailer) affects earnings — verify before altering partner graphs.

## Related

- [features/pre-ipo.md](../features/pre-ipo.md)
- [api/v2.md](../api/v2.md)
- [modules/investor.md](investor.md)
