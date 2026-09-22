# Webhooks & Third-Party APIs

## Webhooks (`WebhookController`)

| Route | Handler | Purpose |
|-------|---------|---------|
| `GET|POST /api/digio-webhook` | `digio` | Digio document events |
| `GET|POST /api/webhook/digio` | `digio` | Same |
| `GET|POST /api/webhook/11za` | `whatsapp` | WhatsApp provider callbacks |
| `GET|POST /api/webhook/calendly` | `calendly` | Calendly booking events |
| `GET /api/share-price-update` | `sharePrice` | External price push |
| `POST /api/test-request` | `testRequest` | Test harness |

Digio completion typically flows into transaction helpers (`changeTransactionStatus`).

## Third-party sandbox

```text
Middleware: ThirdPartyApiAuthMiddleware
Prefix: /api/sandbox/external
Throttle: tpThrottle (e.g. 20/min list, 40/min item)
Controller: ThirdParty\StartupController
```

Clients table: `ApiClient` (`api_clients`) with token + allowed domains + optional `is_ai`.

## AI AutoWork ingest

```text
Middleware: ThirdPartyApiAuthMiddleware + aiClient
Prefix: /api/sandbox/ai
Throttle: tpThrottle 30/min
Controller: ThirdParty\AiCompanyIngestController
```

- Client type **AI AutoWork** (`is_ai=1`), usually `allowed_domains=*`
- That token may call all `/api/sandbox/ai/*` routes
- Routes: `GET schema`, `POST/PATCH/GET companies`
- Staging only — see [features/ai-autowork-company-ingest.md](../features/ai-autowork-company-ingest.md)

## Basic auth external sample

`ApiBasicAuthMiddleware` → `/api/external/get-sample-company` (hardcodes `company_id = 8` for sample).

## Open form ingest (no `headtoken`, no login)

`POST /api/privatedeals/submit-data` (`PrivateDealsController@submitData`)

- For the **privatedeals.in** website form.
- Accepts any POST form / JSON fields and emails them to `privatedeals.in@gmail.com` via existing SMTP (`PMailerTrait`).
- `OPTIONS` allowed for CORS. Throttled (`20/min`).
- Not inside `ApiHeaderAuthMiddleware`.

## Test / ops endpoints (caution)

`TestController` exposes company lists, news save (unguessable path token), push notification test, `login-unauth`. Treat as sensitive; do not expand without auth.

## Related

- [integrations/overview.md](../integrations/overview.md)
- [features/primary-transactions.md](../features/primary-transactions.md)
