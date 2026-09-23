# Swimlane D — Admin or Seller creates a company

**Participants:** Admin · Seller · System  

Shared company records (same companies in both applications).

Editable PlantUML: [../plantuml/swimlane-D.puml](../plantuml/swimlane-D.puml)

---

## Confirmed behaviour

- Admin and Seller can create companies.  
- Seller: if company already exists → **use existing**; **no duplicate**.  
- Seller can **edit only** companies it originally created (not Admin’s or another Seller’s).  
- Duplicate-matching criteria and required fields: **unconfirmed**.  
- Admin edit permissions: **unconfirmed** — not invented.

---

## Diagram

```mermaid
flowchart TB
  subgraph Admin [Admin]
    A1[Create company]
    A2[Company stored as shared record]
    A1 --> A2
  end

  subgraph Seller [Seller]
    S1[Start create company]
    S2{Company already exists? — criteria unconfirmed}
    S3[Use existing company — do not create duplicate]
    S4[Create new company — ownership = this Seller]
    S5{Edit company?}
    S6{Originally created by this Seller?}
    S7[Allow edit]
    S8[Deny edit]
    S1 --> S2
    S2 -->|Yes| S3
    S2 -->|No| S4
    S5 --> S6
    S6 -->|Yes| S7
    S6 -->|No| S8
  end

  subgraph System [System]
    Y1[Save shared company]
    Y2[Enforce no Seller duplicate]
    Y3[Enforce Seller edit ownership]
  end

  A2 --> Y1
  S4 --> Y1
  S2 --> Y2
  S6 --> Y3
```

---

## PlantUML

See [../plantuml/swimlane-D.puml](../plantuml/swimlane-D.puml)
