# Development Conventions (for humans & AI)

## Do

- Read `docs/` for the feature before editing.
- Reuse `app/Enums/*` for statuses/types.
- Put shared transaction transitions in Helpers (`PreIpoTransactionHelper`, etc.), not only in one controller.
- Prefer additive API fields; document removals.
- Mirror investor/partner shared method impacts.
- Keep `routes/breadcrumbs.php` in sync with new admin pages.
- Run a **documentation impact check** before finishing ([maintenance/living-docs-rules.md](../maintenance/living-docs-rules.md)).

## Don't

- Invent microservice boundaries that do not exist.
- Rename permission strings / guards / enum **values** without migrations + client coordination.
- “Fix” headtoken failure status from 500 → 401 without product/mobile agreement.
- Commit secrets; avoid pasting credentials into docs.
- Duplicate feature docs (`feature-v2.md`); update the canonical file.
- Assume commented routes/schedules are live.

## Code hotspots

| If you change… | Also check… |
|----------------|-------------|
| Pre-IPO buy | V1 investor, V1 business, V2 investor, helper, coupons, notifications |
| Company fields | Admin company UI, V1/V2 detail formatters, public slug pages, price jobs |
| Digio webhook | All `changeTransactionStatus` helpers |
| KYC upload | V1 + V2 + forge OCR + admin manual review |
| Schedule | Ops expectations + notification volume |

## Style

Match existing Laravel code style in the touched file (naming is often legacy/`Model` suffix). Avoid drive-by refactors in 3k-line controllers unless requested.

## Related

- [architecture/cross-cutting-risks.md](../architecture/cross-cutting-risks.md)
