# Database: Partner network (new system)

**Stakeholders:** diagram + roles below.  
**Start:** [START-HERE](../START-HERE.md)

---

## Relationship picture

```mermaid
erDiagram
  partner ||--o{ partner : "parent creates child"
  partner ||--o{ investor : "owns when channel partner"
  partner ||--o{ company : "seller submits"
  investor ||--o{ pre_ipo_transaction : "on order"
  company ||--o{ company_deals : "has"
```

---

## Roles (target)

| Type | Kind | Created by | Own investors | Notes |
|------|------|------------|---------------|--------|
| Wealth Manager | Channel partner | Admin | Yes | Distributor, Retailer, RM. **Not Seller** |
| Seller | Inventory | Admin | No | **No child users** |
| Distributor | Channel partner | Admin or WM | Yes | Retailers + RM |
| Retailer | Channel partner | Admin, WM, or Distributor | Yes | Investors only |
| Relation Manager (RM) | RM | WM or Distributor | Assigns for parent | Company data + assign investors |

---

## Plain rules

- Admin creates WM, Seller, Distributor, Retailer  
- WM **cannot** create Seller  
- Seller **cannot** create any user  
- RM under WM/Distributor for company data and investor assignment  
- Investors only under WM / Distributor / Retailer  

---

## Related tables (seller commercial)

| Concept | Role |
|---------|------|
| company | Seller create; live; duplicate check |
| bank / demat | Multiple; on deal / transaction |
| company_deals | Select selling company |
| investment transaction | Deal slip bank + demat |

---

## Related

- [Hierarchy](../workflows/flows/wm-create-seller-distributor.md)
- [Actors](../actors/README.md)
- [Database overview](../../database/overview.md)
- [Diagrams](../diagrams/README.md)
