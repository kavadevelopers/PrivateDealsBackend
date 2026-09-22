# Feature: Portfolio

## Purpose

Show investors (and partners) holdings and performance for startup investments and Pre-IPO positions.

## Entry points

- V1 investor: `portfolio`, `portfolio-details`, `portfolio-status`, `portfolio-pre-ipo`, `portfolio-pre-ipo-detail`, `add-portfolio`
- V2 investor: `/portfolio/startup*`, `/portfolio/pre-ipo*`, `/portfolio/combined`, `status`
- V2 business: `portfolio/startup`, `portfolio/pre-ipo` — holdings grouped by investor with computed `total_company_count` and `total_investment_amount`
- V1 business: `get-portfolio`, portfolio details, Pre-IPO portfolio endpoints
- Admin: portfolio insights under permission `portfolio`
- Web investor: `Web\Front\User\Investor\PortfolioController`

## Models

- `PortfolioModel` → `portfolio`
- `PortfolioPreIpoModel` → `portfolio_preipo`
- `PortfolioImportModel`
- Linked companies/startups and transactions

## Business rules

- Combined portfolio (V2) merges startup + Pre-IPO — changing valuation inputs (share price) affects totals.
- Manual `add-portfolio` allows importing external holdings — validate ownership.
- V2 business portfolio lists group by investor (partner sees all RM-linked investors). Totals are computed at query time, not stored on `investor`.
- V2 business pre-IPO portfolio excludes companies with `category=Listed` (same as investor V2 pre-IPO portfolio).

## Risks

- Price update commands (`CompanySharePriceDataUpdate`, today-change) alter displayed PnL.
- Partner vs investor portfolio endpoints differ in filtering — do not unify blindly.

## Related

- [features/companies-pricing.md](companies-pricing.md)
- [features/pre-ipo.md](pre-ipo.md)
