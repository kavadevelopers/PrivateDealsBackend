# Swimlane C — Assign / reassign Investors to Relationship Manager

**Participants:** Wealth Manager or Distributor · Relationship Manager · System  

Editable PlantUML: [../plantuml/swimlane-C.puml](../plantuml/swimlane-C.puml)

---

## Confirmed behaviour

- WM and Distributor can **assign** or **reassign** Investors to a Relationship Manager.  
- RM **cannot** create Investors; manages **assigned** Investors.  
- Retailer assignment permissions: **unconfirmed** — not shown as allowed.

---

## Diagram

```mermaid
flowchart TB
  subgraph Parent [Wealth Manager or Distributor]
    P1[Select Investor]
    P2[Select Relationship Manager]
    P3[Assign or reassign]
    P1 --> P2 --> P3
  end

  subgraph RM [Relationship Manager]
    R1[Sees Investor in assigned list]
    R2[Manages assigned Investor — no create user]
  end

  subgraph System [System]
    S1[Update Investor assignment]
    S2[Notify or refresh RM view]
  end

  P3 --> S1 --> R1 --> R2
  S1 --> S2
```

---

## PlantUML

See [../plantuml/swimlane-C.puml](../plantuml/swimlane-C.puml)
