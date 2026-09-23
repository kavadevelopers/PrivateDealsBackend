# Flowchart — New system (whole marketplace)

**Type:** Flowchart  
**Purpose:** One picture of how work moves from setup → seller inventory → partner invest / sell → complete.

Back to: [Diagrams index](README.md) · [START-HERE](../START-HERE.md)

---

## Main flowchart

```mermaid
flowchart TD
  Setup[Admin creates WM and/or Seller] --> Hierarchy[Channel hierarchy built]
  Hierarchy --> RegCompany[Seller registers company]
  RegCompany --> Dup{Same company already exists?}
  Dup -->|Yes| Stop[Do not add company]
  Dup -->|No| Live[Company is live — no approval]
  Live --> Prices[Seller uploads prices]
  Prices --> Deals[Seller creates deals]
  Deals --> Select[Select company selling shares]
  Select --> Accounts[Bank and demat on deal]
  Accounts --> Home[Partner opens home]
  Home --> Browse{Opportunity type?}
  Browse -->|Home companies| Co[Open company]
  Browse -->|Hot deals| Hot[Open hot deal]
  Browse -->|Sell shares| SellReq[Sell request for specific shares]
  Co --> CreateInv[WM / Distributor / Retailer creates investor]
  Hot --> CreateInv
  CreateInv --> Product{Product?}
  Product -->|Pre-IPO / unlisted| Invest[Click invest]
  Product -->|LP Secondary| Invest
  Invest --> Slip[Deal slip with bank and demat]
  Slip --> Pay[Payment]
  Pay --> Done[Order complete]
  SellReq --> SellDone[Sell request recorded]
```

---

## Hierarchy flowchart

```mermaid
flowchart TB
  Admin[Admin panel] --> WM[Wealth Manager]
  Admin --> SellerTop[Seller]
  WM --> SellerUnder[Seller under WM]
  WM --> WMInv[WM investors]
  WM --> DistWM[Distributor]
  WM --> RetWM[Retailer]
  SellerTop --> DistS[Distributor]
  SellerTop --> RetS[Retailer]
  SellerUnder --> DistS2[Distributor]
  SellerUnder --> RetS2[Retailer]
  DistWM --> DistInv[Investors]
  DistWM --> RetFromDist[Retailers]
  DistS --> DistInv2[Investors]
  DistS --> RetFromDist2[Retailers]
```

---

## Related detail pages

- [Whole story](../START-HERE.md)
- [Hierarchy](../workflows/flows/wm-create-seller-distributor.md)
- [Register company](../workflows/flows/seller-register-company.md)
- [Prices and deals](../workflows/flows/seller-prices-and-deals.md)
- [Invest](../workflows/flows/partner-invest-for-investor.md)
