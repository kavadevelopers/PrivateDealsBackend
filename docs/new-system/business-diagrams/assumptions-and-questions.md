# Assumptions and unresolved questions

## Assumptions (used to draw diagrams; not inventing product rules)

1. “Parent” means the channel partner who created the subordinate (WM→Dist/Retailer/RM/Investor; Dist→Retailer/RM/Investor; Retailer→Investor). Admin-created Dist/Retailer may have **no** parent.
2. Wealth Manager app and Private Deal Seller app are separate clients sharing company (and deal) records via the same backend.
3. Admin operates in a separate Admin application outside this repo’s delivery scope, but is an actor in these workflows.
4. Relationship Manager works inside the Wealth Manager application context for the parent WM or Distributor.
5. “Appears directly in Wealth Manager” after deal create means visible to authorised WM-app users without an approval queue (visibility filters still unconfirmed).
6. Diagrams show proposed target behaviour; current code may differ until implementation.

---

## Confirmed vs provisional vs unknown

| Status | Meaning |
|--------|---------|
| **Confirmed** | Use in diagrams and permission table as written |
| **Provisional** | Shown and labelled; may change (e.g. cascade revoke of investment areas) |
| **Unconfirmed / Unknown** | Kept high-level; listed as questions below — not invented |

---

## Unresolved questions (focused)

### Access & hierarchy
1. How is investment-area access set for **Admin-created independent** Distributors and Retailers (no WM parent)?  
2. Does an **Investor** inherit or hold investment-area access separately from the creating partner?  
3. Can a **Retailer** assign/reassign Investors to a Relationship Manager?  
4. Who creates the relationship between an independent Distributor and later optional linkage to a WM (if any)?

### Login & accounts
5. How are initial credentials delivered after Admin/WM creates a user?  
6. Which fields are mandatory on Admin (and WM) account-creation forms?  
7. Exact behaviour for **blocked** vs **deleted** accounts on login (message, lockout)?

### Company
8. What are the **duplicate-matching** criteria (CIN, name+type, etc.)?  
9. Required fields for company create (Admin vs Seller)?  
10. Can Admin **edit** companies (any / only Admin-created)?  

### Deal
11. Required fields on deal create?  
12. Deal edit / cancel / expiry lifecycle statuses?  
13. Which WM users see which deals (by area, by parent hierarchy, by assignment)?  

### Share price
14. Which company/price records may a Seller update (own companies only?)?  
15. Validation, history, and effect on existing deals/transactions?  

### Cascade access (**Provisional** rule)
16. Confirm or reject: removing an area from a parent automatically removes it from all affected subordinates.

---

## When you send a change

1. Affected rules/diagrams will be listed  
2. Only blocking questions asked  
3. Permission table + diagrams updated together  
4. Unrelated rules preserved  
