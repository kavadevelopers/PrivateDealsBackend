# Swimlane B — Channel partner creates allowed user and grants access

**Participants:** Wealth Manager / Distributor / Retailer (creator) · User receiving access · System  

Editable PlantUML: [../plantuml/swimlane-B.puml](../plantuml/swimlane-B.puml)

---

## Confirmed behaviour

| Creator | May create |
|---------|------------|
| Wealth Manager | Investor, Relationship Manager, Distributor, Retailer |
| Distributor | Retailer, Investor, Relationship Manager |
| Retailer | Investor only |

- Parent may grant subordinate **all or subset** of parent’s enabled investment areas.  
- Parent **cannot** grant an area it does not have.  
- **Provisional:** removing an area from parent removes it from affected subordinates.  
- Independent Dist/Retailer access setup: **unconfirmed**.

---

## Diagram

```mermaid
flowchart TB
  subgraph Creator [WM or Distributor or Retailer]
    C1[Choose create Investor / RM / Dist / Retailer — if allowed]
    C2{Allowed for this role?}
    C3[Stop — not permitted]
    C4[Create user]
    C5{Grant investment areas?}
    C6[Select only areas creator has]
    C7[Skip area grant if Investor-only path / unconfirmed]
    C1 --> C2
    C2 -->|No| C3
    C2 -->|Yes| C4 --> C5
    C5 -->|Yes| C6
    C5 -->|N/A or unconfirmed| C7
  end

  subgraph NewUser [User receiving access]
    N1[Can later log in with mobile and password]
  end

  subgraph System [System]
    S1[Save user and parent link if any]
    S2[Save granted areas within parent set]
    S3[PROVISIONAL — cascade revoke when parent loses area]
  end

  C4 --> S1
  C6 --> S2
  S2 -.-> S3
  S1 --> N1
```

---

## PlantUML

See [../plantuml/swimlane-B.puml](../plantuml/swimlane-B.puml)
