# Use cases — Admin

Admin is an **external supporting actor**. The Admin application is outside this project’s available scope. Admin can **view all data**.

Editable PlantUML: [../plantuml/use-case-admin.puml](../plantuml/use-case-admin.puml)

---

## Diagram (Mermaid)

```mermaid
flowchart LR
  Admin((Admin))

  subgraph AdminApp [Admin application — outside scope]
    UC1([Create Wealth Manager])
    UC2([Create Seller])
    UC3([Create Distributor])
    UC4([Create Retailer])
    UC5([Assign WM investment areas])
    UC6([Create company])
    UC7([View all data])
  end

  Admin --> UC1
  Admin --> UC2
  Admin --> UC3
  Admin --> UC4
  Admin --> UC5
  Admin --> UC6
  Admin --> UC7
```

---

## Responsibilities (confirmed)

| Use case | Notes |
|----------|--------|
| Create Wealth Manager | Yes |
| Create Seller | Yes |
| Create Distributor | Yes — parent **not** mandatory |
| Create Retailer | Yes — parent **not** mandatory |
| Assign WM investment areas | Primary / LP Secondary / Unlisted — one, two, or all |
| Create company | Shared company records |
| View all data | Yes |

**Out of current Admin scope:** create Investors; create Relationship Managers.

---

## PlantUML source

```plantuml
@startuml
left to right direction
actor "Admin" as Admin
rectangle "Admin application (outside scope)" {
  usecase "Create Wealth Manager" as UC1
  usecase "Create Seller" as UC2
  usecase "Create Distributor" as UC3
  usecase "Create Retailer" as UC4
  usecase "Assign WM investment areas" as UC5
  usecase "Create company" as UC6
  usecase "View all data" as UC7
}
Admin --> UC1
Admin --> UC2
Admin --> UC3
Admin --> UC4
Admin --> UC5
Admin --> UC6
Admin --> UC7
note right of UC3
  Parent not mandatory
end note
@enduml
```
