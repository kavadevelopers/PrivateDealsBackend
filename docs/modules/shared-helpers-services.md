# Module: Shared Helpers, Services, Repositories

## Purpose

Cross-cutting business logic and infrastructure used by web + API.

## Helpers (`app/Helpers/`)

| Helper | Role |
|--------|------|
| `PreIpoTransactionHelper` | Pre-IPO status lists (V1/V2), Digio-driven status changes, deal slip, cancel notifications |
| `PrimaryTransactionHelper` | Primary status / document progression |
| `SecondaryTransactionHelper` | Sell request + transaction status, allotment, SH4, Digio status |
| `TransactionCalculationHelper` | Pricing / fee calculations (used by V2 calculate endpoint) |
| `DigioHelper` | Digio API: KYC/PAN verify, document send/sign flows (~700+ lines) |
| `FileUpDownHelper` | Uploads/downloads across document types / disks |
| `DocumentHelper` | Document entity helpers |
| `WhatsAppMessagesHelper` | Outbound WhatsApp message construction/queueing |
| `BseCalendarHelper` / `SettlementDateHelper` / `PreIpoBusinessDayService` | Business-day aware scheduling |
| `AdminHelper` | Admin utilities |
| `CommonHelper` / `UtillsHelper` | Shared utilities (large) |
| `SMSHelper` | SMS |
| `WebhookHelper` | Webhook utilities |
| `ThemeHelper` | Admin/front theme |
| SEO helpers | Public meta/URL |

**AI note:** Prefer extending helpers for transaction state changes rather than duplicating status logic in controllers.

## Services (`app/Services/`)

| Service | Role |
|---------|------|
| `FCMService` | Firebase cloud messaging |
| `DematKycService` | Demat KYC processing |
| `DematPdfParsingService` | CML/demat PDF parse |
| `PreIpoTimerService` | Pre-IPO timing windows |
| `PreIpoBusinessDayService` | Business day calculations |

## Repositories

- `CommonRepository`, `InvestorRepository`, `PartnerRepository`, `StartupRepository`
- `V2\InvestorRepository`

Registered via `RepositoryServiceProvider`.

## Jobs (`app/Jobs/`)

Examples: `FirebasePushNotificationSendJob`, `PushNotificationJob`, WhatsApp job classes, `SecondaryAllocationJob`, `SecondaryRofrJob`, `PreIpoSharePriceUpdateJob`, KYC notification jobs, `OfferLetterSendJob`, `SendDealSlipJob`, Calendly-related sync is a command (`SyncCalendlyBookings`).

## Enums

Always use `app/Enums/*` for statuses/types (`CompanyTypeEnum`, `PrimaryTransactionStatusEnum`, `PaymentStatusEnum`, `DocumentTypeEnum`, …).

## Traits / Actions / DataTables / Exports

- `app/Traits/*` — shared model/controller traits
- `app/Actions/GetThemeType.php`
- `app/DataTables/*` — Yajra tables for admin lists
- `app/Exports/*` — Excel exports
