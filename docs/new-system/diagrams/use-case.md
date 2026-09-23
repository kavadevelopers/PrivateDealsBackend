# Use case diagram — New system

**Type:** Use case  
Back to: [Diagrams](README.md) · [START-HERE](../START-HERE.md)

---

## Use case overview

```mermaid
flowchart TB
  subgraph Actors [Actors]
    Admin((Admin))
    WM((Wealth Manager))
    Seller((Seller))
    Dist((Distributor))
    Ret((Retailer))
    RM((RM))
  end

  subgraph System [New system]
    UC1([Create WM / Seller / Distributor / Retailer])
    UC2([Create Distributor and Retailer under WM])
    UC3([Create RM])
    UC4([Manage company data])
    UC5([Assign investors])
    UC6([Register company])
    UC7([Upload prices and deals])
    UC8([Browse home and Hot deals])
    UC9([Create investor])
    UC10([Invest Pre-IPO or LP Secondary])
    UC11([Deal slip bank and demat])
    UC12([Sell request])
    UC13([Monitor])
  end

  Admin --> UC1
  Admin --> UC13
  WM --> UC2
  WM --> UC3
  WM --> UC8
  WM --> UC9
  WM --> UC10
  WM --> UC11
  WM --> UC12
  Seller --> UC6
  Seller --> UC7
  Dist --> UC3
  Dist --> UC8
  Dist --> UC9
  Dist --> UC10
  Dist --> UC11
  Dist --> UC12
  Ret --> UC8
  Ret --> UC9
  Ret --> UC10
  Ret --> UC11
  Ret --> UC12
  RM --> UC4
  RM --> UC5
```

---

## By actor

| Actor | Use cases |
|-------|-----------|
| Admin | Create WM, Seller, Distributor, Retailer; monitor |
| WM | Channel (Distributor, Retailer, RM, investors); browse; invest; sell request. **Not** create Seller |
| Seller | Register company; prices/deals. **No** create users |
| Distributor | Retailers, RM, investors; invest path |
| Retailer | Investors only; invest path |
| RM | Company data; assign investors for WM/Distributor |

---

## Related

- [Swimlane](swimlane-activity.md) · [Flowchart](flowchart.md) · [Hierarchy](../workflows/flows/wm-create-seller-distributor.md)
