# Feature: Coupons & Referrals

## Purpose

Campaign coupons for investments and investor referral / company share links.

## Coupons

- Models: `MasterCouponModel`, `CouponCompanyModel`, `InvestorCouponModel`
- Enums: `CouponTypeEnum`, `CouponCompanyScopeEnum`, `InvestorCouponStatusEnum`
- Admin: `/admin/coupon` (permission `company`)
- API V2: `/api/v2/investor/coupon/applicable`, `coupon/search`

## Referrals / share links

- V2: `referal-link-creation`, `company-share-link-creation` (spelling `referal` as in route)
- Models: `InvestorReferralModel`, `CompanyShareLinkModel`, possibly `DynamicUrlModel`

## Business rules

- Coupon applicability is company-scoped — changing scope enums affects checkout.
- Referral codes collected during V2 registration `complete`.

## Risks

- Typo'd route name `referal` — keep alias if renaming.
- Discount math lives near Pre-IPO calculate/buy — test both.

## Related

- [features/pre-ipo.md](pre-ipo.md)
- [api/v2.md](../api/v2.md)
