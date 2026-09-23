# Database Overview

## Engine

- MySQL (`DB_CONNECTION=mysql`)
- Migrations: `database/migrations/` (~363 files)
- Seeder: minimal (`database/seeders` — largely rely on admin setup / existing DB)
- Soft conventions: many tables are **singular** names (`investor`, `company`, `partner`)

## Domain map

```mermaid
erDiagram
  investor ||--o{ pre_ipo_transaction : places
  investor ||--o{ primary_transaction : commits
  investor ||--o{ secondary_transaction : trades
  investor ||--o{ portfolio : holds
  investor ||--o{ portfolio_preipo : holds
  partner ||--o{ investor : manages
  partner ||--o{ partner : "parent creates child"
  company ||--o{ pre_ipo_transaction : underlying
  startup ||--o{ primary_transaction : raises
  documents ||--o{ pre_ipo_transaction : attaches
```

Partner network detail (types, Seller target role, hierarchy): [new-system/database/partner.md](../new-system/database/partner.md).

## Key tables ↔ models (non-exhaustive)

### Actors
| Table | Model |
|-------|-------|
| `investor` | `InvestorModel` |
| `partner` | `PartnerModel` |
| `startup` | `StartupModel` |
| `user_admin` | `UserAdminModel` |
| `seller_master` | `SellerMasterModel` (`is_primary_access`, `is_secondary_access`, `is_preipo_access`) |

### Markets & content
| Table | Model |
|-------|-------|
| `company` | `CompanyModel` (+ `type`) |
| `temp_company` | `TempCompanyModel` (AI AutoWork staging) |
| company price/news/* | matching `Company*Model` |
| startup* | `Startup*Model` family |

### Transactions
| Table | Model |
|-------|-------|
| `pre_ipo_transaction` | `PreIpoModel` |
| `primary_transaction` | `PrimaryTransactionModel` |
| `secondary_transaction` | `SecondaryTransactionModel` |
| secondary sell/payments/escrow/transfer | matching models |
| `portfolio` / `portfolio_preipo` | portfolio models |

### KYC / banking
Investor KYC/demat/bank/AIF models as listed in [features/kyc-demat.md](../features/kyc-demat.md).

### Comms / API infra
| Table | Model |
|-------|-------|
| API header tokens | `ApiTokenForHeaderAuthModel` |
| `api_log` | `ApiLogModel` |
| `api_clients` | `ApiClient` (+ `is_ai`) |
| WhatsApp/email/SMS reports | `ReportMessages*` |
| device tokens | `CoreFirebaseDeviceTokenModel` |
| `app_settings` | `AppSettingsModel` |

## Migrations guidance

- Prefer new migrations over editing old ones already applied in shared environments.
- When adding columns used by APIs (e.g. `company.type`), update Enum + API docs + feature docs together.

## Unknowns

- No single schema dump in repo; infer from models + migrations.
- Some legacy tables may exist without active code paths — verify `grep` before dropping.

## Related

- Feature docs under `docs/features/`
- [architecture/cross-cutting-risks.md](../architecture/cross-cutting-risks.md)
