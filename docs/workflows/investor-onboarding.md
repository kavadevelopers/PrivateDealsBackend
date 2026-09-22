# Workflow: Investor Onboarding

```mermaid
flowchart TD
  A[App installs / opens] --> B[headtoken validated]
  B --> C{V1 or V2?}
  C -->|V2| D[send-otp]
  D --> E[verify-otp]
  E --> F[complete registration + MPIN]
  F --> G[Sanctum token]
  C -->|V1| H[validate-send-code]
  H --> I[verify-code]
  I --> J[set-pin]
  J --> G
  G --> K[Optional Google link / profile]
  K --> L[KYC: PAN / Aadhaar / Demat / Bank]
  L --> M{KYC OK?}
  M -->|Manual review| N[Admin manual KYC]
  N --> O[Invest features unlocked]
  M -->|Verified| O
```

## Key files

- V2: `Api\V2\Investor\AuthController`, KYC methods on `CommonController`
- V1: `Api\V1\Investor\LoginController`, `CommonKycController`
- Digio: `DigioHelper`
- Jobs: KYC notification / reminder jobs
- Admin: manual KYC routes

## Business rules

- MPIN required for login (V2) and sensitive checks
- Referral code optional at V2 complete
- Pending KYC reminders run hourly when scheduled

## Side effects

- Device token registration (guest + authenticated)
- WhatsApp/push may fire on KYC completion / manual review

## Related

- [features/kyc-demat.md](../features/kyc-demat.md)
- [authentication/overview.md](../authentication/overview.md)
