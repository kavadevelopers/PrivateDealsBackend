# Swimlane activity diagram — New system

**Type:** Swimlane (activity by role)  
**Purpose:** Show **who** does each activity across Admin, Seller, WM / Distributor / Retailer, and the System.

Back to: [Diagrams index](README.md) · [START-HERE](../START-HERE.md)

---

## Swimlane — Setup to company live

```mermaid
flowchart TB
  subgraph AdminLane [Admin]
    direction TB
    A1[Create WM Seller Distributor Retailer]
    A2[Seller is inventory only]
    A3[See / monitor companies and orders]
    A1 --> A2
  end

  subgraph SellerLane [Seller]
    direction TB
    S1[Register company]
    S2{Duplicate company?}
    S3[Company live — no approval]
    S4[Do not add]
    S1 --> S2
    S2 -->|No| S3
    S2 -->|Yes| S4
  end

  subgraph ChannelLane [WM / Distributor / Retailer — channel partners]
    direction TB
    C0[Build channel — WM: Dist/Retailer/RM — Dist: Retailer/RM]
    C0 --> C1[Wait for live companies]
  end

  subgraph RMLane [RM]
    direction TB
    R1[Manage company data]
    R2[Assign investors]
    R1 --> R2
  end

  A2 --> S1
  A1 --> C0
  S3 --> C1
  S3 -.-> A3
  C0 -.-> R1
```

---

## Swimlane — Prices, deals, invest, deal slip

```mermaid
flowchart TB
  subgraph SellerLane [Seller]
    direction TB
    S1[Upload prices]
    S2[Create deal]
    S3[Select company selling shares]
    S4[Attach bank and demat]
    S5[Track assigned orders]
    S1 --> S2 --> S3 --> S4
  end

  subgraph ChannelLane [WM / Distributor / Retailer]
    direction TB
    P1[Open home — companies and Hot deals]
    P2[Create own investor]
    P3[Invest Pre-IPO / unlisted or LP Secondary]
    P4[Read bank and demat on deal slip]
    P5[Complete payment path]
    P1 --> P2 --> P3 --> P4 --> P5
  end

  subgraph RMLane [RM]
    direction TB
    R1[Manage company data / assign investors as needed]
  end

  subgraph SystemLane [System]
    direction TB
    Y1[Show live catalog and Hot deals]
    Y2[Create transaction]
    Y3[Issue deal slip with settlement details]
    Y4[Mark order complete]
    Y1 --> Y2 --> Y3 --> Y4
  end

  subgraph AdminLane [Admin]
    direction TB
    A1[See / monitor orders]
  end

  S4 --> Y1
  P1 --> Y1
  P3 --> Y2
  Y3 --> P4
  P5 --> Y4
  Y2 -.-> A1
  Y4 --> S5
  R1 -.-> P2
```

---

## Swimlane — Sell request (branch)

```mermaid
flowchart TB
  subgraph ChannelLane [WM / Distributor / Retailer]
    direction TB
    P1[Choose company / specific shares]
    P2[Submit sell request]
    P1 --> P2
  end

  subgraph SystemLane [System]
    direction TB
    Y1[Record sell request]
    Y2[Visible for ops / sellers as needed]
    Y1 --> Y2
  end

  subgraph AdminLane [Admin]
    direction TB
    A1[See / complete sell requests]
  end

  subgraph SellerLane [Seller]
    direction TB
    S1[May see sell-side interest]
  end

  P2 --> Y1
  Y2 -.-> A1
  Y2 -.-> S1
```

---

## How to read this

| Lane | Meaning |
|------|---------|
| **Admin** | Creates WM, Seller, Distributor, Retailer; monitors |
| **Seller** | Inventory only — **no users** |
| **WM / Distributor / Retailer** | Channel partners |
| **RM** | Company data + assign investors for WM/Distributor |
| **System** | Catalog, transaction, deal slip |

---

## Related

- [Flowchart](flowchart.md)
- [Use case](use-case.md)
- [START-HERE](../START-HERE.md)
