# Module: Partner / Business (new system)

**Start:** [START-HERE](../START-HERE.md) · [Actors](../actors/README.md) · [Diagrams](../diagrams/README.md)

---

## Purpose

Partner network for the **new system**: **channel partners** (WM, Distributor, Retailer), **RM**, and **Seller** (inventory).

---

## Role summary

| Role | Kind | Created by | Creates / has |
|------|------|------------|----------------|
| Wealth Manager | Channel partner | Admin | Distributor, Retailer, investors, **RM**. **Not Seller.** |
| Seller | Inventory | Admin only | Companies, prices, deals only. **No users.** |
| Distributor | Channel partner | Admin or WM | Retailers, investors, **RM** |
| Retailer | Channel partner | Admin, WM, or Distributor | Investors only |
| RM | Relation Manager | WM or Distributor | Company data + assign investors |

---

## Capabilities

### Admin
- Create WM, Seller, Distributor, Retailer
- See / monitor

### Wealth Manager
- Channel + own investors + RM
- Browse home / Hot deals; invest; deal slip; sell request

### Seller
- Register company (live, no approval; block duplicates)
- Prices, deals, selling company, bank/demat
- No channel users, no investors

### Distributor
- Same invest path as WM for own investors
- Retailers + RM

### Retailer
- Own investors only; invest path

### RM
- Manage company data for WM or Distributor
- Assign investors

Detail hierarchy: [Hierarchy](../workflows/flows/wm-create-seller-distributor.md)

---

## Related

- [START-HERE](../START-HERE.md)
- [Database](../database/partner.md)
- [Current API notes](../../api/v2.md) (code may differ until migration)
