# Feature: AI AutoWork (hub)

## Purpose

Admin hub for autonomous AI jobs that write to **staging** first. Humans review and approve before master data changes.

## Entry points

- Admin: `/admin/ai-autowork/*` (`AiAutoworkController`, `AiCompanyIngestAdminController`)
- Permission: Spatie `ai_autowork` (guard `admin`)
- Sidebar section heading **AI AUTOWORK** (same pattern as **USERS**):
  - **Company** → Inbox, Guide (company URLs → copy prompt for AI)
  - **Share Prices (Soon)**

## Jobs

| Job | Status | Admin | Docs |
|-----|--------|-------|------|
| Company Ingest | Live | Inbox + Guide | [ai-autowork-company-ingest.md](ai-autowork-company-ingest.md) |
| Share Prices | Stub only | Coming soon + guide placeholder | TBD |

## Auth pattern for AI vendors

- Table: `api_clients` — header `X-AUTH-TOKEN`
- Flag: `is_ai` — set Client type to **AI AutoWork** in admin
- Server AI: `allowed_domains=*`
- Middleware `aiClient` on `/api/sandbox/ai/*`: only `is_ai=1` clients allowed; they may call **all** AI routes (no per-job scopes)
- Investor / business / admin / sandbox-external stay on their own auth

## Adding a new job

1. New temp table + ingest API under `/api/sandbox/ai/...` (same AI client token works)
2. Admin inbox + **separate** AI Guide page
3. Feature doc `docs/features/ai-autowork-{job}.md`
4. Hub overview / sidebar links

## Related

- [ai-autowork-company-ingest.md](ai-autowork-company-ingest.md)
- [companies-pricing.md](companies-pricing.md)
- [../api/webhooks-third-party.md](../api/webhooks-third-party.md)
