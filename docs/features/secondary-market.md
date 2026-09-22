# Feature: Secondary Market

## Purpose

Facilitate secondary share opportunities: sell requests, allotment, ROFR, escrow/payment confirmation, share transfer receipts, SH4 documents.

## Entry points

- API V1 investor/business: `/secondary-invest/*` (sell-now, buy-now, transactions, ROFR, share receipt upload/approve, payment-received)
- API V2 investor: read list/detail under `/secondary/transaction*`
- Admin: secondary transactions, secondary sell request, secondary payment receipts
- Startup web (if enabled): sell-request status endpoints

## Important models

- `SecondaryTransactionModel` → `secondary_transaction`
- `SecondarySellRequestModel`
- `SecondaryPaymentsModel`
- `SecondaryEscrowAccountModel`
- `SecondaryShareTransferModel`

## Helper

`SecondaryTransactionHelper`:

- Status lists for apps
- `allotShares`, `sendShareRequest`, `sendSH4`
- Digio-driven `changeTransactionStatus`
- `changeOppotunityStatus` (spelling as in code)

## Jobs

- `SecondaryAllocationJob`
- `SecondaryRofrJob`

## Business rules

- ROFR status posts update workflow gates before transfer completes.
- Share receipt upload/approve involves buyer/seller roles — verify actor permissions in controller before changing.
- Some payment-receipt upload routes are commented in `api.php` — may be deprecated; confirm before re-enabling.

## Risks

- Typo'd method names (`Oppotunity`) — search both spellings when refactoring.
- Escrow and payment-received notifications (`notify_seller_payment_received_from_buyer_in_escrow` style keys) couple to WhatsApp/templates.

## Related

- [workflows/secondary-trade.md](../workflows/secondary-trade.md)
- [features/pre-ipo.md](pre-ipo.md) (note: `company.type=secondary` is a **company market classification**, distinct from this secondary *startup share* market — do not conflate without reading calling code)
