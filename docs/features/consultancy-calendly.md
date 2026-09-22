# Feature: Consultancy (Calendly)

## Purpose

Let investors book consultancy slots via Calendly; sync bookings into ShuruUp.

## Entry points

- API V2: `/consultancy/calendly-booking-url`, `book-slot`, `my-slots`
- Webhook: `POST/GET /api/webhook/calendly`
- Command: `calendly:sync` every minute (`SyncCalendlyBookings`)

## Config (`.env`)

- `CALENDLY_SCHEDULING_LINK`, `CALENDLY_EVENT_PATH`
- `CALENDLY_TOKEN`, `CALENDLY_USER_URI`

## Models

- `InvestorConsultancySlotModel` (and related booking fields as implemented)

## Business rules

- Tracking parameter (`a1`) links Calendly invitee to investor — webhook auto-link; `book-slot` can attach if webhook already created row.
- Missing env yields friendly API error (“not configured”).

## Risks

- Minute sync + webhook can race — controllers already handle “not found yet” messaging; preserve that UX.
- Token leakage via logs.

## Related

- [integrations/overview.md](../integrations/overview.md)
- [api/webhooks-third-party.md](../api/webhooks-third-party.md)
