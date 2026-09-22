# Module: Partner / Business

## Purpose

The **partner network** runs the marketplace channel: Wealth Managers, Distributors, Retailers, Relation Managers, and (target) **Sellers**.

**Stakeholder product path:** Partners **create investors** and **invest for them**. Sellers **register companies**, set prices/deals, and track orders.

**Start here for the story:** [Whole project flow](../workflows/whole-project-flow.md) · [Actors hub](../actors/README.md)

---

## Partner types

| Type | Plain language |
|------|----------------|
| Wealth Manager | Can **create Seller** and **Distributor** (target) |
| **Seller** (target) | Registers companies → go live → prices/deals → track orders |
| Distributor | Channel partner |
| Retailer | Channel partner |
| Relation Manager | Channel partner |

> **Current vs target:** Today’s enum may not yet include `seller`; some seller APIs still use `seller_master`. These docs describe the **intended** model. Code later.

Admin UI historically splits types under `/admin/partner/...`.

---

## Surfaces

| Surface | Entry |
|---------|--------|
| API V1 | `/api/v1/business/*` → `Api\V1\Business\*` (+ reused investor methods for buys) |
| API V2 | `/api/v2/business/*` → `Api\V2\Business\*` |
| Web partner portal | Controllers exist historically; treat **API + admin** as primary surfaces unless routes are confirmed live |

## Auth

- Model: `PartnerModel` (`partner`)
- Guards: `partner` (session), `partner-api-guard` (Sanctum)

---

## Capabilities by role (stakeholder view)

### Wealth Manager

- Create **Seller** and **Distributor** (target)
- Channel / MIS as applicable

### Seller (target role)

- Register company (pending → live after approval)
- Set prices and deals
- Track orders linked to them  
Detail: [Flows B–D, H](../workflows/whole-project-flow.md)

### Channel partners (Distributor / Retailer / RM / WM acting as partner)

- See **live** companies
- Optional enquiry
- **Create investor**
- **Invest for that investor**  
Detail: [Flows E–G](../workflows/whole-project-flow.md)

---

## Important capabilities (V1 API — technical)

- Dashboard + Pre-IPO dashboard
- Primary/secondary transaction lists
- Channel partner CRUD
- Investor create/update under partner
- Earnings (investor / partner)
- Portfolio views
- Pending tasks, documents, notifications
- Pre-IPO buy/sell via shared investor controller methods

## Important capabilities (V2 API — technical)

- Pre-IPO / secondary homes, company list/detail
- Investor detail, Pre-IPO transaction list
- Portfolio startup + pre-IPO
- Enquiries create
- Empty stubs for some `primary` / `secondary` prefixes

## Important files

- `Api\V1\Business\CommonController`, `LoginController`, `CommonKycController`
- `Api\V2\Business\CommonController`, `PortfolioController`, `EnquiryController`
- `Repositories\PartnerRepository`
- Admin: `Web\Admin\Partner\*`

## Dependencies

- Investor records with `partner_id`
- Same transaction tables as investor flows
- Companies, deals, prices; WhatsApp company report jobs

## Risks

- Reused investor endpoints: changing investor Pre-IPO buy also changes partner app behavior.
- V2 filters **unlisted** vs **secondary** — see `preipo-v2-unlisted-secondary-api-changes.md`.
- Hierarchy / earnings — verify before altering partner graphs.
- Seller-as-partner-type not in code yet — do not assume enum values until implemented.

## Related

- [Whole project flow](../workflows/whole-project-flow.md)
- [Actors hub](../actors/README.md)
- [Partner schema](../database/partner.md)
- [features/pre-ipo.md](../features/pre-ipo.md)
- [api/v2.md](../api/v2.md)
