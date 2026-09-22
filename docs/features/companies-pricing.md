# Feature: Companies, Pricing & News

## Purpose

Master data for investable companies: fundamentals, promoters, shareholders, daily/share prices, news, peer ratios, grab opportunity slots, company deals, price alerts.

## Entry points

- Admin: `/admin/company/*` (`CompanyController`) — CRUD, price OCR, WhatsApp PDF reports
- Admin: `/admin/company/pending-seller` — approve/reject seller-submitted companies (`approval_status=pending`)
- Admin: `/admin/ai-autowork/company-ingest/*` — AI staging inbox (see [ai-autowork-company-ingest.md](ai-autowork-company-ingest.md)); does not write master until approve
- Admin company list more-options **Share Prices**: modal on `/admin/company/list` to browse `company_share_price` history (paginated), filter by date from/to, and delete a row. AJAX `GET /admin/company/share-price/{uuid}` + `DELETE /admin/company/share-price/{uuid}/{id}`. Does not add/edit prices. After delete, `CompanyModel::syncPricesFromHistory()` refreshes denormalized `company` prices from remaining history (or zeros them if none remain). New prices still come from sidebar **Update Share Price** (`company_daily_share_price` + OCR/jobs).
- Admin: `/admin/company-deals/*` (`CompanyDealController`) — company deals CRUD; create/edit set **Added By** (Admin or seller), **`deal_type` buy|sell**, `expired_at`, `is_hot_deal`; list shows Type + Hot + Expiry
- Admin: `/admin/company-enquiry/*` (`CompanyEnquiryController`) — partner buy/sell enquiries (Pending/Completed; sidebar after Secondary Sell Request)
- API: Seller V2 company create/list/detail/my-submissions (`/api/v2/seller/company/*`) — create only (pending approval); list/detail are approved catalog; list includes `is_editable` when `submitted_by_seller_id` matches the authenticated seller; `POST .../promoters` and `POST .../shareholders` replace-all on the seller’s company. Shareholders POST is year-grouped (`year` + `shareholders[]` of `name`/`percentage`), matching detail `share_holders`; tables are still `company_share_holder` + `company_share_holder_percentage`.
- API: Seller V2 `POST /api/v2/seller/company/update-share-price` — batch seller quotes (`sell_price`, optional `buy_price`, `min_qty`, optional `total_qty`) for multiple approved companies; appends `seller_company_share_price` history; sets `company.is_price_updated_today`. Does not write admin market price tables.
- API: Seller V2 `GET /api/v2/seller/dashboard` — summary cards (own deals available/expired, pending approvals, catalog total, prices uploaded today), charts, recent deals/submissions/transactions
- API: Seller V2 deals CRUD (`/api/v2/seller/company/deals*`) — seller create/list on approved **unlisted or secondary**; **`deal_type` required (`buy`|`sell`)**; `available_quantity` optional (create defaults to `0`; update omit keeps current); list returns **own deals only** with optional `type` (`All`\|`unlisted`\|`secondary`); update/delete own deals only; supports `expired_at` (datetime `Y-m-d H:i:s`) + `is_hot_deal`
- API: Business V2 `GET /api/v2/business/home/pre-ipo` includes `data.hot_deals` — unlisted companies with hot deals (no pagination); nested buy/sell deals with each deal’s own `share_price`
- API: `POST /api/v2/business/enquiries/create` (`EnquiryController`) — partner enquiry on company or deal
- API: Seller V2 `GET /api/v2/seller/sell-enquiries/list` (`SellEnquiryController`) — lists **all** partner **sell** enquiries (not ownership-scoped)
- API company detail/market/news: V1 + V2 investor/business
- Public web: company detail by slug
- Webhooks: `share-price-update` on `WebhookController`
- Commands: `CompanySharePriceDataUpdate`, `CompanySharePriceUpdateTodayChange`, `PrivateEquitySharePrice`

## Models

- `CompanyModel` → `company` (**`type`**: `unlisted` | `secondary`; **`approval_status`**: `pending` | `approved` | `rejected`; seller submits set `submitted_by_seller_id`; **`is_price_updated_today`**: seller quote flag, separate from admin `price_updated_today`)
- `CompanyDealModel` → `company_deals` (per-company inventory deals; **`deal_type`**: `buy` | `sell` (default `sell`); status `available` | `half_sold` | `sold`; optional `created_by_seller_id`; optional `expired_at`; `is_hot_deal` default false)
- `CompanyEnquiryModel` → `company_enquiries` (partner enquiry: buy/sell, qty, offer price, valid till; optional `deal_id`; stores `user_id` + `user_type`)
- `CompanySharePriceModel`, `CompanyDailySharePriceModel`, `SellerCompanySharePriceModel` (seller-only quote history)
- `CompanyNewsModel`, `CompanyFundamentalsModel`, `CompanyPromotersModel`
- `CompanyShareHolderModel`, `CompanyShareHolderPercentageModel`
- `CompanyPeerRatioModel`, `CompanyCustomDataModel`, `CompanyEventsModel`
- `CompanyPriceAlertModel`, `CompanyShareLinkModel`, `CompanyGrabOpportunitySlotModel`

## Business rules

- `CompanyTypeEnum` market separation for business Pre-IPO APIs.
- `CompanyApprovalStatusEnum` gates visibility: investor/business/seller catalog APIs use `CompanyModel::approved()` scope. Do **not** overload `company.status` (raising/completed) for approval. DB default is **`pending`**; migration backfills existing catalog rows to **`approved`**. Admin create/import/AI promote set `approved` explicitly; seller API create sets `pending`.
- Seller may **create** companies via V2 (no edit) with an admin-like field set (fees default commission/processing 2%; `is_free_processing_fee=1`; optional depository/PAN/ISIN/RTA/total_shares; no keywords/trending/grab/52w fields). Create rejects duplicate normalized CIN or same normalized legal `company_name` + `type`. Use `POST /api/v2/seller/company/check-duplicate` before create. New rows start as `pending` until admin approves on `/admin/company/pending-seller`.
- Business V2 company payloads (`company/detail`, `company/list`, `home/pre-ipo`, `home/secondary`, and `home/pre-ipo` → `hot_deals`) expose partner pricing as: retail `share_price` unchanged; `base_price` = today’s lowest `sell_price` from `seller_company_share_price` for that company, or `share_price` when there are no seller updates today; `distributer_price` is set equal to that `base_price` in the response only.
- Business V2 `company/detail` also returns `seller_share_prices` (today’s seller quotes only, lowest sell first). Each item includes `date`, `sell_price`, `buy_price`, `min_qty`, `total_qty`, and nested `seller` (`id`, `uuid`, `company_name`, `logo`). Admin chart history remains under `share_prices`.
- Seller V2 `company/detail` returns the same `seller_share_prices` shape (today only, ordered by `sell_price` ascending).
- List/home company queries exclude `category=Listed` by default. Pass `category=Listed` on `company/list` (business) or `view-all` (investor) to return listed companies only.
- Admin company create/edit: Category **All** saves `category` as `NULL` (general pool, not `Listed`).
- Slug is set in admin `CompanyController` on create, update, and excel import via `AdminHelper::companySlug` (same pattern as sector/blog). Backfill: `php artisan seo:generate-slugs` (use `--force` carefully — overwrites).
- Top gainers/losers helpers must keep `slug` for v2 clients.
- Company list **Share Prices** modal lists historical `company_share_price` (date, price, distributer_price, base_price), newest date first. Date from/to filters stay sticky. Rows load 15 at a time **on scroll** (infinite scroll). Delete removes that row in place (scroll position is kept). After delete, current `company.share_price` / `distributer_price` / `base_price` / `last_year_share_price` are resynced from remaining history. If no history remains, those fields and 52-week high/low are set to `0`. `CalcuatePricingAutoJob` uses the same `syncPricesFromHistory()` rule.
- Seller share-price quotes: `POST /api/v2/seller/company/update-share-price` accepts a `prices[]` batch; each row appends `seller_company_share_price` (`company_id`, `seller_id`, `date`, `sell_price`, optional `buy_price`, `min_qty`, optional `total_qty`). Sets `company.is_price_updated_today=1` for updated companies. Exposed on seller company list. Daily command `app:company-share-price-update-today-change` resets both `price_updated_today` and `is_price_updated_today` to `0`. Independent of admin Update Share Price / market denormalized prices.
- Company deals: admin + seller managed rows on `company_deals` (`deal_type` buy|sell, `available_quantity`, `share_price`, `minimum_qty`, `processing_fee_percentage`, `status`, `expired_at` datetime, `is_hot_deal`). Soft-deleted via `is_deleted`. **Business V2 company detail** exposes all non-expired deals for that company only (any creator; hot first; includes `deal_type` + nested `seller` when `created_by_seller_id` is set). **Business V2 `home/pre-ipo` → `data.hot_deals`** returns all **unlisted** companies that have at least one hot non-expired deal (no pagination), with nested buy/sell `deals[]` (deal `share_price` is per-deal). Standalone `home/hot-deals` removed. Not on Investor detail. Partner enquiry optional deal must belong to that company and not be expired. Sellers CRUD via Seller V2 on approved **`unlisted` or `secondary`** (list = own deals only; update/delete own only; `deal_type` required). Seller create sets `processing_fee_percentage=0` server-side. Admin/legacy deals with null creator are not seller-editable. Existing deals without an explicit type were backfilled as `sell`.
- Company enquiries (v1): partners only via Business V2. Allowed for `company.type` unlisted or secondary. Optional deal must belong to that company. Fields: `enquiry_type` (`buy`|`sell`), `quantity`, `offer_price`, optional `offer_valid_till`, optional `notes`. Persists inquirer as `user_id` + `user_type` (`PartnerModel`). Admin marks pending → completed; soft-deletes via `is_deleted`. No convert-to-order and no notifications in v1. **Seller V2** `GET /api/v2/seller/sell-enquiries/list` returns **all** `enquiry_type=sell` rows (optional `status`, `company_id`, `skip`/`take`). Buy enquiries are not exposed on seller APIs.

## Risks

- OCR price import can mis-parse rows — admin-only but writes production prices.
- Daily scheduled price jobs — failures leave stale market UI.
- Deleting a `company_share_price` history row is permanent. If it was the last row, live `company` prices become `0` (APIs, list, charts that pad from `company.share_price`).

## Related

- [preipo-v2-unlisted-secondary-api-changes.md](../preipo-v2-unlisted-secondary-api-changes.md)
- [features/pre-ipo.md](pre-ipo.md)
