# Swimlane F — Seller updates a share price (high level)

**Participants:** Seller · System  

Editable PlantUML: [../plantuml/swimlane-F.puml](../plantuml/swimlane-F.puml)

---

## Confirmed behaviour

- Seller **can** update share prices.  

## Unconfirmed (do not invent)

- Eligible records / ownership restrictions  
- Validation rules  
- Price history  
- Effect on existing deals or transactions  
- Do **not** infer share-price rights from company-edit rights  

---

## Diagram

```mermaid
flowchart TB
  subgraph Seller [Seller]
    S1[Choose company or price record — eligibility unconfirmed]
    S2[Enter new share price]
    S3[Submit update]
    S1 --> S2 --> S3
  end

  subgraph System [System]
    Y1[Apply update — validation unconfirmed]
    Y2[Store result — history unconfirmed]
    Y3[Impact on deals or transactions — unconfirmed]
    Y1 --> Y2 --> Y3
  end

  S3 --> Y1
```

---

## PlantUML

See [../plantuml/swimlane-F.puml](../plantuml/swimlane-F.puml)
