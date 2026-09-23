# Module: Partner / Business

## Purpose

The **partner network** runs the marketplace channel: Wealth Managers, Distributors, Retailers, Relation Managers, and (target) **Sellers**.

**Stakeholder product path:** Partners **create investors** and **invest for them**. Sellers **register companies**, set prices/deals, and track orders.

**Start here for the story:** [Whole project flow](../workflows/whole-project-flow.md) · [Actors hub](../actors/README.md)

---

## Partner types

| Type | Plain language |
|------|----------------|
| Wealth Manager | **Main.** Created by **Admin**. Creates Seller, Distributor, Retailer; **own investors** |
| **Seller** (target) | Created by **Admin** (like WM) **or** under WM. Has Distributor + Retailer below. Prices/deals. **No own investors** |
| Distributor | Under WM **or** Seller. **Own investors** + **own retailers** |
| Retailer | Under WM, Seller, or Distributor. **Own investors** only |

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

### Wealth Manager (main)

- Created from **Admin panel**
- Create **Seller**, **Distributor**, and **Retailer** (direct under WM)
- Has **own investors** and can invest for them
- Channel / MIS as applicable

### Seller (target role)

- Created from **Admin panel** (same idea as creating WM) **or** under WM
- Can have **Distributor** and **Retailer** below
- **Does not** have own investors
- Register company — **live immediately**, **no approval**; if the **same company already exists**, do not add
- Upload **prices**, **deals**, and related deals (same Seller)
- Hold **multiple companies selling shares** and **multiple bank / demat** accounts
- On deal create: **must select the company who is selling the shares**
- Track orders linked to them  
Detail: [Flows B–D, H](../workflows/whole-project-flow.md) · Hierarchy: [Flow A](../workflows/flows/wm-create-seller-distributor.md)

### Distributor

- Under **WM** or under **Seller**
- Has **own investors**
- Has **own retailers**
- Invest for own investors (home / Hot deals; Pre-IPO or LP Secondary; deal slip bank+demat)

### Retailer

- Under **WM**, **Seller**, or **Distributor**
- Has **own investors** only
- Invest for own investors (same invest pattern)

### Who invests / sell requests (WM, Distributor, Retailer — not Seller)

- See **home** companies and **Hot deals**
- **Create investor** under themselves and **invest for them**
- Product types: **Pre-IPO / unlisted** and **LP Secondary** — **same invest process**
- On invest: receive that deal’s **bank and demat** on the **deal slip** (transaction level)
- Raise a **sell request** for **specific shares**  
Detail: [Flows E–G, I](../workflows/whole-project-flow.md) + [Flow H](../workflows/flows/order-to-complete.md)  
Hierarchy detail: [Flow A](../workflows/flows/wm-create-seller-distributor.md)

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
