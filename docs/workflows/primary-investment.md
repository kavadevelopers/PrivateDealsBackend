# Workflow: Primary Investment

```mermaid
flowchart TD
  Discover[View startup / round] --> Commit[POST invest-now / commitNow]
  Commit --> SSA[SSA sent/signed via Digio]
  SSA --> MGT[MGT-14]
  MGT --> Offer[Offer letter send/sign]
  Offer --> Pay[Payment + receipt]
  Pay --> PAS[PAS-3]
  PAS --> SHA[SHA]
  SHA --> Complete[Completed]
```

Statuses are defined in `PrimaryTransactionStatusEnum` and advanced via `PrimaryTransactionHelper` + Digio webhooks + admin/startup uploads.

## Actors

- Investor / partner apps create commitment
- Admin / startup ops upload legal docs
- Digio handles e-sign where configured

## Related

- [features/primary-transactions.md](../features/primary-transactions.md)
- [modules/startup.md](../modules/startup.md)
