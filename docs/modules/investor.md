# Module: Investor

## Purpose

End-user investors: discover companies/startups, invest (primary/secondary/Pre-IPO), complete KYC, manage portfolio, family profiles, notifications.

## Surfaces

| Surface | Entry |
|---------|--------|
| Web | `routes/web.php` investor prefixes + `Web\Front\User\Investor\*` + auth controllers |
| API V1 | `/api/v1/investor/*` → `Api\V1\Investor\*` |
| API V2 | `/api/v2/investor/*` → `Api\V2\Investor\*` |

## Auth model

- Model: `InvestorModel` (`investor` table)
- Web guard: `investor`
- API guard: `investor-api-guard` (Sanctum `HasApiTokens`)
- V2 registration: OTP → verify → complete (manual or Google) + MPIN
- V1 registration: validate-send-code → verify → set-pin

## Important files

| Concern | Location |
|---------|----------|
| V2 product API | `Api\V2\Investor\CommonController` |
| V2 auth | `Api\V2\Investor\AuthController` |
| V2 price alerts | `Api\V2\Investor\PriceAlertController` |
| V2 calc | `Api\V2\Investor\TransactionCalculationController` |
| V1 product API | `Api\V1\Investor\CommonController` |
| V1 KYC uploads | `Api\V1\Investor\CommonKycController` |
| V1 login | `Api\V1\Investor\LoginController` |
| Repository | `Repositories\InvestorRepository`, `Repositories\V2\InvestorRepository` |

## Key features used

- Pre-IPO buy/sell/cancel, payment receipt upload (V2)
- Primary commit + payment receipt
- Secondary buy/sell + ROFR + share receipts
- KYC / demat PDF parse (“forge”)
- Portfolio startup + Pre-IPO + combined (V2)
- Coupons, referrals, company share links (V2)
- Calendly consultancy slots (V2)
- Favorites, family profiles, AIF submit

## Dependencies

- Companies, startups, documents, Digio, WhatsApp/FCM jobs
- Partners (referral / RM relationships)
- BSE calendar helpers for settlement / business days

## Business rules (preserve)

- MPIN checks on sensitive actions (`check-mpin`)
- KYC gates often required before investing (verify in controller before relaxing)
- Family/switch-profile changes which investor context is active

## Risks for AI changes

- V1 and V2 duplicates: fix both or document intentional divergence.
- Partner APIs call investor methods for Pre-IPO buy/sell — side effects beyond investor apps.
- Response shape changes break mobile apps without versioning.

## Related

- [features/pre-ipo.md](../features/pre-ipo.md)
- [workflows/investor-onboarding.md](../workflows/investor-onboarding.md)
- [api/v2.md](../api/v2.md)
