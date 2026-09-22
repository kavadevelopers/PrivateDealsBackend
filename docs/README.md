# PrivateDeals V1 — Documentation Index

**Living source of truth** for humans and AI coding agents.  
Source code always wins if docs and code disagree — update the docs.

---

## How to use this documentation

```text
Project Overview
    ↓
Architecture
    ↓
Modules / Features
    ↓
Database + APIs + Workflows
    ↓
Auth / Config / Integrations
    ↓
Development / Deployment / Troubleshooting
```

Before changing code: read relevant docs → implement → **documentation impact check** → update docs if behavior changed.  
See [maintenance/living-docs-rules.md](maintenance/living-docs-rules.md).

---

## Navigation

### Start here (stakeholders — Partner marketplace)
| Document | Purpose |
|----------|---------|
| [**workflows/whole-project-flow.md**](workflows/whole-project-flow.md) | **Whole project flow** — one page + flowchart (show in meetings) |
| [actors/README.md](actors/README.md) | Who is who + links to every individual flow |
| [database/partner.md](database/partner.md) | Partner network schema (Seller as partner role — target) |

### Individual flows (click any step)
| Document | Purpose |
|----------|---------|
| [flows/wm-create-seller-distributor.md](workflows/flows/wm-create-seller-distributor.md) | A — WM creates Seller & Distributor |
| [flows/seller-register-company.md](workflows/flows/seller-register-company.md) | B — Seller registers company |
| [flows/company-goes-live.md](workflows/flows/company-goes-live.md) | C — Company goes live |
| [flows/seller-prices-and-deals.md](workflows/flows/seller-prices-and-deals.md) | D — Prices & deals |
| [flows/partner-discovers-company.md](workflows/flows/partner-discovers-company.md) | E — Partner sees company |
| [flows/partner-create-investor.md](workflows/flows/partner-create-investor.md) | F — Partner creates investor |
| [flows/partner-invest-for-investor.md](workflows/flows/partner-invest-for-investor.md) | G — Partner invests for them |
| [flows/order-to-complete.md](workflows/flows/order-to-complete.md) | H — Order completes |

### Start here (engineering)
| Document | Purpose |
|----------|---------|
| [documentation-plan.md](documentation-plan.md) | Approved analysis plan that produced this tree |
| [project-overview.md](project-overview.md) | What PrivateDeals is, actors, product domains |
| [architecture/overview.md](architecture/overview.md) | System shape, layers, major dependencies |
| [architecture/request-lifecycle.md](architecture/request-lifecycle.md) | How web/API requests flow |
| [architecture/cross-cutting-risks.md](architecture/cross-cutting-risks.md) | Coupling, fat controllers, change risks |

### Modules (by actor / surface)
| Document | Purpose |
|----------|---------|
| [modules/admin.md](modules/admin.md) | Admin portal (`/admin`) |
| [modules/investor.md](modules/investor.md) | Investor web + API |
| [modules/partner-business.md](modules/partner-business.md) | Partner network (incl. target Seller role) + business API |
| [modules/startup.md](modules/startup.md) | Startup portal + API |
| [modules/public-website.md](modules/public-website.md) | Public marketing site (migrated Blade site) |
| [modules/shared-helpers-services.md](modules/shared-helpers-services.md) | Helpers, services, repositories |

### Features
| Document | Purpose |
|----------|---------|
| [features/pre-ipo.md](features/pre-ipo.md) | Unlisted / Pre-IPO trading |
| [features/primary-transactions.md](features/primary-transactions.md) | Startup primary fundraising |
| [features/secondary-market.md](features/secondary-market.md) | Secondary transfers / ROFR |
| [features/kyc-demat.md](features/kyc-demat.md) | KYC, PAN/Aadhaar, demat, bank |
| [features/portfolio.md](features/portfolio.md) | Startup + Pre-IPO portfolios |
| [features/companies-pricing.md](features/companies-pricing.md) | Company master, prices, news, deals, partner enquiries |
| [features/ai-autowork.md](features/ai-autowork.md) | AI AutoWork hub (staging → admin approve) |
| [features/ai-autowork-company-ingest.md](features/ai-autowork-company-ingest.md) | AI company ingest API + temp_company promote |
| [features/notifications-comms.md](features/notifications-comms.md) | WhatsApp, push, email |
| [features/coupons-referrals.md](features/coupons-referrals.md) | Coupons, referrals, share links |
| [features/consultancy-calendly.md](features/consultancy-calendly.md) | Calendly booking |

### Data & APIs
| Document | Purpose |
|----------|---------|
| [database/overview.md](database/overview.md) | Schema domains, key tables/models |
| [database/partner.md](database/partner.md) | Partner table, types, hierarchy (target Seller) |
| [api/overview.md](api/overview.md) | API auth layers, versioning |
| [api/v1.md](api/v1.md) | Investor / business / startup v1 |
| [api/v2.md](api/v2.md) | Investor / business v2 |
| [api/webhooks-third-party.md](api/webhooks-third-party.md) | Webhooks + sandbox |

### Workflows
| Document | Purpose |
|----------|---------|
| [workflows/whole-project-flow.md](workflows/whole-project-flow.md) | **Stakeholder:** full partner marketplace flow |
| [workflows/flows/](workflows/flows/) | Individual flows A–H |
| [workflows/investor-onboarding.md](workflows/investor-onboarding.md) | Register → MPIN → KYC |
| [workflows/pre-ipo-buy-sell.md](workflows/pre-ipo-buy-sell.md) | Buy/sell/cancel Pre-IPO |
| [workflows/primary-investment.md](workflows/primary-investment.md) | Commit → docs → payment |
| [workflows/secondary-trade.md](workflows/secondary-trade.md) | Sell request → allot → transfer |

### Cross-cutting
| Document | Purpose |
|----------|---------|
| [authentication/overview.md](authentication/overview.md) | Guards, Sanctum, headtoken, permissions |
| [configuration/environment.md](configuration/environment.md) | `.env`, settings, filesystem |
| [integrations/overview.md](integrations/overview.md) | Digio, WhatsApp, FCM, Calendly, OCR, AWS, Google |
| [deployment/overview.md](deployment/overview.md) | Run, queue, schedule, deploy notes |
| [development/setup.md](development/setup.md) | Local setup |
| [development/conventions.md](development/conventions.md) | Code patterns for AI/dev |
| [troubleshooting/common-issues.md](troubleshooting/common-issues.md) | Frequent failures |
| [maintenance/living-docs-rules.md](maintenance/living-docs-rules.md) | **Required** docs update process |

### Change logs / focused notes
| Document | Purpose |
|----------|---------|
| [preipo-v2-unlisted-secondary-api-changes.md](preipo-v2-unlisted-secondary-api-changes.md) | `company.type` unlisted vs secondary API notes |

---

## Quick facts

| Item | Value |
|------|--------|
| Stack | Laravel 11, PHP 8.2+, MySQL, Livewire 3, Sanctum, Spatie Permission |
| Entry routes | `routes/web.php`, `routes/api.php`, `routes/console.php` |
| Models | ~136 Eloquent models under `app/Models/` |
| Migrations | ~363 under `database/migrations/` |
| Default admin (from root README) | username `shuruup` / password `PrivateDeals@123` |

---

## AI agent checklist (every task)

1. Read this index + the feature/module docs for the area you touch.
2. Prefer Helpers (`app/Helpers/*`) and existing Enums over inventing new status strings.
3. V1 and V2 investor APIs often share models but diverge in controllers — check both.
4. Changing Pre-IPO / primary / secondary status logic affects admin web, jobs, Digio webhooks, and mobile apps.
5. Before finishing: update affected docs in the same task.
