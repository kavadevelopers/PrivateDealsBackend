# Use cases — Wealth Manager and related roles

Wealth Manager application. Related roles: Distributor, Retailer, Relationship Manager, Investor (as managed record).

Editable PlantUML: [../plantuml/use-case-wealth-manager.puml](../plantuml/use-case-wealth-manager.puml)

---

## Diagram (Mermaid)

```mermaid
flowchart TB
  WM((Wealth Manager))
  Dist((Distributor))
  Ret((Retailer))
  RM((Relationship Manager))

  subgraph WMApp [Wealth Manager application]
    L([Login — then area selection])
    C_Inv([Create Investor])
    C_RM([Create Relationship Manager])
    C_Dist([Create Distributor])
    C_Ret([Create Retailer])
    Grant([Grant investment areas — subset of own])
    Assign([Assign / reassign Investors to RM])
    Browse([Browse companies and deals in authorised areas])
    Invest([Invest for Investor])
    SellReq([Sell request for specific shares])
    ManageRM([Manage assigned Investors])
  end

  WM --> L
  WM --> C_Inv
  WM --> C_RM
  WM --> C_Dist
  WM --> C_Ret
  WM --> Grant
  WM --> Assign
  WM --> Browse
  WM --> Invest
  WM --> SellReq
  Dist --> L
  Dist --> C_Inv
  Dist --> C_RM
  Dist --> C_Ret
  Dist --> Grant
  Dist --> Assign
  Dist --> Browse
  Dist --> Invest
  Dist --> SellReq
  Ret --> L
  Ret --> C_Inv
  Ret --> Browse
  Ret --> Invest
  Ret --> SellReq
  RM --> L
  RM --> ManageRM
```

---

## Who creates whom (confirmed)

| Actor | Creates |
|-------|---------|
| Wealth Manager | Investors, Relationship Managers, Distributors, Retailers |
| Distributor | Retailers, Investors, Relationship Managers |
| Retailer | Investors |
| Relationship Manager | **Nobody** — manages **assigned** Investors only |

WM **cannot** create Seller.

---

## Investment areas

Access permissions (not roles): Primary Startup (PE) · Secondary Startup (LP Secondary) · PRE-IPO (Unlisted).

- Admin assigns WM’s areas.  
- Parent grants subordinates only areas the parent has.  
- **Provisional:** removing an area from parent cascades to subordinates.

---

## PlantUML source

```plantuml
@startuml
left to right direction
actor "Wealth Manager" as WM
actor "Distributor" as Dist
actor "Retailer" as Ret
actor "Relationship Manager" as RM

rectangle "Wealth Manager application" {
  usecase "Login then area selection" as L
  usecase "Create Investor" as CInv
  usecase "Create Relationship Manager" as CRM
  usecase "Create Distributor" as CDist
  usecase "Create Retailer" as CRet
  usecase "Grant investment areas subset" as Grant
  usecase "Assign Investors to RM" as Assign
  usecase "Browse in authorised areas" as Browse
  usecase "Invest for Investor" as Invest
  usecase "Sell request" as Sell
  usecase "Manage assigned Investors" as Manage
}

WM --> L
WM --> CInv
WM --> CRM
WM --> CDist
WM --> CRet
WM --> Grant
WM --> Assign
WM --> Browse
WM --> Invest
WM --> Sell

Dist --> L
Dist --> CInv
Dist --> CRM
Dist --> CRet
Dist --> Grant
Dist --> Assign
Dist --> Browse
Dist --> Invest
Dist --> Sell

Ret --> L
Ret --> CInv
Ret --> Browse
Ret --> Invest
Ret --> Sell

RM --> L
RM --> Manage

note bottom of WM
  Cannot create Seller
end note
@enduml
```
