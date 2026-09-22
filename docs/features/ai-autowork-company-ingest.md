# Feature: AI AutoWork — Company Ingest

## Purpose

Third-party AI posts company data into `temp_company`. Admins edit and approve; only then data is copied into live `company` + related tables. News, share prices, and peer ratios are **not** part of this job.

## Auth

| Item | Value |
|------|--------|
| Header | `X-AUTH-TOKEN: {api_clients.token}` |
| Client type | AI AutoWork (`is_ai=1`) |
| Allowed domains | `*` (server AI) |
| Admin setup | System Configuration → API Clients |

One AI client token may call **all** `/api/sandbox/ai/*` routes (this job and future jobs).

## Routes

| Method | Path |
|--------|------|
| GET | `/api/sandbox/ai/schema` |
| POST | `/api/sandbox/ai/companies` |
| PATCH | `/api/sandbox/ai/companies/{uuid}` |
| GET | `/api/sandbox/ai/companies/{uuid}` |

Throttle: 30/min. Middleware: `ThirdPartyApiAuthMiddleware` + `aiClient`.

## Ingest rules

- Required: `cin` **or** (`brand_name` + `company_name`)
- Accepted keys: `external_ref`, `company`, `fundamentals`, `promoters`, `shareholders`, `events`, `financials`
- Ignored keys returned in `ignored_keys` (still stored in `raw_payload`)
- Same normalized CIN while `status=pending` → upsert same temp row
- After `approved`, new POST for that CIN → new proposal
- Live CIN match → `intent=update` + `matched_company_id`

## Admin

- `/admin/ai-autowork/company-ingest` — inbox
- `/admin/ai-autowork/company-ingest/{uuid}` — review / save temp / approve / reject
- Events: if more than 5, keep latest 5 by date (enforced on ingest + admin save)
- `company.is_drhp` from badge/tag "DRHP Filed" (also accepts `drhp` / `drhp_filed` / tags containing DRHP)
- `company.logo_url` downloaded to temp logo on ingest/save/approve when possible; review shows remote URL fallback
- Promoters from Leadership/Management: every person + experience + LinkedIn url
- Shareholders: scrape ALL year tabs; year-keyed object accepted; review shows year tabs like Financials
- Review: human tabs/forms; Category/BG removed; logo upload; financials read-only as P&L / Balance Sheet / Cash Flow / Ratios tables (year-keyed JSON is pivoted to Particulars × FY columns)
- Guide prompt: agent/API only — no admin review/approve/staging workflow text in the copied prompt
- Payload example lives in `GET /api/sandbox/ai/schema` → `example_body` (not hardcoded in the copied prompt)
- Flow today: admin copies prompt → paste into OpenClaw/agent manually (no direct agent dispatch from admin yet)
- On promote, financial `values` are normalized to a 2D matrix (year-keyed AI JSON → Particulars × FY table) so investor company detail / admin financial editors keep working
- Investor `extractFinancialHighlights` also accepts year-keyed custom_data (no Undefined array key 0)
- Approve & promote saves the review form first, then validates; then `PromoteTempCompanyService`
- Reject sets `status=rejected` + notes
- Inbox: **Reopen** (approved/rejected → pending for edit + re-approve); **Delete** removes temp ingest row only (not live company)
- `AdminHelper::logPut` on approve / reject / reopen / delete

## Models / tables

- `TempCompanyModel` → `temp_company`
- Promote writes: `company`, `company_fundamentals`, promoters, shareholders (+ %), events, `company_custom_data`

## Related

- [ai-autowork.md](ai-autowork.md)
- [companies-pricing.md](companies-pricing.md)
