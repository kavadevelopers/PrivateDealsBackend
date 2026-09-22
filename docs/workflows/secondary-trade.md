# Workflow: Secondary Trade

```mermaid
flowchart TD
  Sell[POST sell-now / sell request] --> Opp[Opportunity visible on market]
  Opp --> Buy[POST buy-now]
  Buy --> ROFR[ROFR status updates]
  ROFR --> Escrow[Payment / escrow confirmation]
  Escrow --> Receipt[Share receipt upload / approve]
  Receipt --> Docs[SH4 / Digio docs]
  Docs --> Done[Transfer complete]
```

## Core code

- API: V1 `secondary-invest/*`
- `SecondaryTransactionHelper` (`allotShares`, `sendSH4`, status changers)
- Jobs: `SecondaryAllocationJob`, `SecondaryRofrJob`
- Models: `SecondarySellRequestModel`, `SecondaryTransactionModel`, payments/escrow/transfer models

## Preserve

- Role checks on approve/payment-received endpoints
- Notification keys to seller/buyer

## Related

- [features/secondary-market.md](../features/secondary-market.md)
