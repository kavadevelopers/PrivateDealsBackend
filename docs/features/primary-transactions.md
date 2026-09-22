# Feature: Primary Transactions

## Purpose

Track investor commitments into startup fundraising rounds through legal and payment milestones.

## Status machine

`PrimaryTransactionStatusEnum` (labels):

1. Commitment Pending  
2. Committed  
3. SSA Sent / SSA Signed  
4. MGT-14 Completed  
5. Offer Letter Sent / Signed  
6. Payment Received  
7. PAS-3 Uploaded  
8. SHA Sent  
9. Completed  

Logic: `PrimaryTransactionHelper` + Digio webhook-driven `changeTransactionStatus` patterns (similar to secondary/Pre-IPO).

## Entry points

- API V1 investor: `primary-invest/*`, `primary-transaction-list`, `primary-transaction-detail`, `commitNow`, payment receipt upload
- API V1 business: parallel list/detail + invest-now
- API V2 investor: `primary/transaction`, `primary/transaction/detail` (read-focused in routes)
- Admin: `/admin/primary-transactions`, payment receipt screens
- Startup admin tools: MGT14, PAS3, offer request controllers

## Models / tables

- `PrimaryTransactionModel` → `primary_transaction`
- `PrimaryTransactionPaymentModel`
- `PrimaryTransactionPresentationModel`
- `PrimaryTransactionMgt14Model`, `PrimaryTransactionPas3Model`
- Related `DocumentsModel` / signers
- `StartupRoundModel`, `StartupFundRaiseModel`

## Payment modes

`PrimaryTransactionPaymentMode` enum — validated on invest/commit APIs.

## Jobs

- `OfferLetterSendJob`
- Notification jobs on buy/cancel paths as wired from controllers

## Business rules

- Status order matters for admin filters and mobile timelines — do not rename enum values without migration + client update.
- Document completion via Digio advances status; manual admin uploads may also call helpers.

## Risks

- Cross-module: startup ops + admin + investor/partner APIs share one transaction table.
- Commented V2 business primary routes — do not assume V2 partner primary APIs exist.

## Related

- [workflows/primary-investment.md](../workflows/primary-investment.md)
- [modules/startup.md](../modules/startup.md)
