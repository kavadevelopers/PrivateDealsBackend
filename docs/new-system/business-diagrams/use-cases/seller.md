# Use cases — Private Deal Seller

Private Deal Seller application. Seller has **no subordinate users or roles**.

Editable PlantUML: [../plantuml/use-case-seller.puml](../plantuml/use-case-seller.puml)

---

## Diagram (Mermaid)

```mermaid
flowchart LR
  Seller((Seller))

  subgraph SellerApp [Private Deal Seller application]
    L([Login → dashboard])
    CCo([Create company])
    UseExisting([Use existing company if already present])
    EditOwn([Edit own created companies only])
    CDeal([Create deal for a company])
    Price([Update share price — high level])
    View([View / interact with relevant users in process])
  end

  Seller --> L
  Seller --> CCo
  Seller --> UseExisting
  Seller --> EditOwn
  Seller --> CDeal
  Seller --> Price
  Seller --> View
```

---

## Responsibilities (confirmed)

| Use case | Notes |
|----------|--------|
| Login → dashboard | No area-selection page (unlike WM app) |
| Create company | Shared records; no duplicate if exists |
| Edit company | **Only** companies this Seller originally created |
| Create deal | No Admin approval; available in Wealth Manager |
| Update share price | High-level; detailed rules unconfirmed |
| View/interact users | During business process only — **no** account create/manage |

**Cannot:** create or manage user accounts / roles.

---

## PlantUML source

```plantuml
@startuml
left to right direction
actor "Seller" as Seller
rectangle "Private Deal Seller application" {
  usecase "Login to dashboard" as L
  usecase "Create company" as CCo
  usecase "Use existing company if duplicate" as Use
  usecase "Edit own companies only" as Edit
  usecase "Create deal" as Deal
  usecase "Update share price" as Price
  usecase "View relevant users in process" as View
}
Seller --> L
Seller --> CCo
Seller --> Use
Seller --> Edit
Seller --> Deal
Seller --> Price
Seller --> View
note right of Seller
  No subordinate users
end note
@enduml
```
