# Swimlane E — Seller creates a deal → available in Wealth Manager

**Participants:** Seller · System · Wealth Manager app users (consume)

Editable PlantUML: [../plantuml/swimlane-E.puml](../plantuml/swimlane-E.puml)

---

## Confirmed behaviour

- Seller creates a deal associated with a company.  
- After success, deal appears in Wealth Manager.  
- **No Admin approval** for publication.  
- Required fields, edit rules, lifecycle statuses: **unconfirmed**.  
- Area access does **not** automatically mean every deal is visible — further visibility rules **unconfirmed**.

---

## Diagram

```mermaid
flowchart TB
  subgraph Seller [Seller]
    S1[Select company]
    S2[Enter deal details — fields unconfirmed]
    S3[Submit create deal]
    S1 --> S2 --> S3
  end

  subgraph System [System]
    Y1[Validate and save deal]
    Y2[Publish — no Admin approval]
    Y3[Make available to Wealth Manager application]
    Y1 --> Y2 --> Y3
  end

  subgraph WM [Wealth Manager application]
    W1[Authorised users may see deal]
    W2[Exact visibility filters — unconfirmed]
    W1 --> W2
  end

  S3 --> Y1
  Y3 --> W1
```

---

## PlantUML

See [../plantuml/swimlane-E.puml](../plantuml/swimlane-E.puml)
