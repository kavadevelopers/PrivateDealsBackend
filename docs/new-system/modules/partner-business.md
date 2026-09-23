# Module: Partner / Business (new system)

**Start:** [START-HERE](../START-HERE.md) · [Business diagrams](../business-diagrams/README.md) · [Actors](../actors/README.md)

---

## Purpose

**Wealth Manager** app (channel partners + Relationship Manager) and **Private Deal Seller** app (Seller only). Admin is external.

---

## Role summary

| Role | Creates |
|------|---------|
| Admin | WM, Seller, Dist, Retailer (not Inv/RM) |
| Wealth Manager | Inv, Relationship Manager, Dist, Retailer — **not Seller** |
| Distributor | Retailer, Inv, Relationship Manager |
| Retailer | Investor |
| Relationship Manager | — (assigned Investors) |
| Seller | — (no users); companies, deals, prices |

See [role-permissions.md](../business-diagrams/role-permissions.md).

---

## Related

- [START-HERE](../START-HERE.md)
- [Database](../database/partner.md)
- [Hierarchy](../workflows/flows/wm-create-seller-distributor.md)
- [Current API notes](../../api/v2.md) (code may differ until migration)
