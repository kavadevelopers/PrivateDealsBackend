# Module: Startup

## Purpose

Startup companies raising capital: profile, rounds, MIS, updates, MGT-14 / PAS-3 / offer requests, secondary sell-request handling, cap table management (web).

## Surfaces

| Surface | Status / entry |
|---------|----------------|
| Admin management | Active — `/admin/startup/*` |
| Front user portal | Controllers exist under `Web\Front\User\Startup\*`; large blocks of `/raise` routes in `web.php` are **commented out** — verify which login paths still work before documenting UI URLs as live |
| API V1 | `/api/v1/startup/login`, authenticated `dashboard`, `logout` — thin |

## Auth

- Model: `StartupModel` (`startup`)
- Guards: `startup`, `startup-api-guard`

## Important models

`StartupDetailsModel`, `StartupRoundModel`, `StartupFundRaiseModel`, `StartupMisModel`, `StartupUpdateModel`, `StartupDocumentModel`, `StartupPitchModel`, `StartupTeamModel`, `StartupManageCaptableModel`, `StartupOfferRequestModel`, legal/financial/CMS-related startup models, links to `PrimaryTransactionModel`.

## Admin controllers

`Web\Admin\Startup\*`: Livepitch, MGT14, MIS, OfferRequest, Pas3, Update; plus `StartupController` / `StartupControllerOld`.

## Business rules

- Primary transaction statuses progress through legal document milestones (`PrimaryTransactionStatusEnum`).
- Offer letters / Digio signing interact with document helpers and jobs (`OfferLetterSendJob`).

## Risks / unknowns

- Exact production availability of startup self-serve web UI (commented route groups).
- Overlap between `StartupController` and `StartupControllerOld`.

## Related

- [features/primary-transactions.md](../features/primary-transactions.md)
- [workflows/primary-investment.md](../workflows/primary-investment.md)
