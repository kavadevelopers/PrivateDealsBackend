# Actors hub — New system

**Naming:** **Relationship Manager**  
**Diagrams:** [business-diagrams/README.md](../business-diagrams/README.md)

---

## Who is who

| Role | App | Notes |
|------|-----|--------|
| Admin | External Admin app | Creates WM/Seller/Dist/Retailer; view all; not Investors/RMs |
| Wealth Manager | WM app | Creates Inv/RM/Dist/Retailer; cannot create Seller |
| Distributor | WM app | Creates Retailer/Inv/RM; Admin or under WM |
| Retailer | WM app | Creates Investors only |
| Relationship Manager | WM app | Assigned Investors only; no user create |
| Seller | Seller app | Companies/deals/prices; no subordinate users |
| Investor | Record | Owned by WM/Dist/Retailer |

---

## Show first

| Doc | Link |
|-----|------|
| START-HERE | [../START-HERE.md](../START-HERE.md) |
| Business diagrams | [../business-diagrams/README.md](../business-diagrams/README.md) |
| Role permissions | [../business-diagrams/role-permissions.md](../business-diagrams/role-permissions.md) |
| Hierarchy | [../workflows/flows/wm-create-seller-distributor.md](../workflows/flows/wm-create-seller-distributor.md) |
