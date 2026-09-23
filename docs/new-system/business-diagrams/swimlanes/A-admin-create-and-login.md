# Swimlane A — Admin creates account → login → authorised access

**Participants:** Admin · User receiving access · System  

Editable PlantUML: [../plantuml/swimlane-A.puml](../plantuml/swimlane-A.puml)

---

## Confirmed behaviour

- Admin creates Wealth Manager, Seller, Distributor, or Retailer (not Investor/RM in this scope).  
- Login: mobile + password.  
- Success: **no** onboarding / profile / KYC gate in this proposed flow.  
- WM-app users: always **investment-area selection** after login (even if one area).  
- Seller: **dashboard** after login.  
- Failures: invalid credentials; blocked/deleted account.  
- No mandatory password change in this flow.  
- Credential delivery and mandatory create fields: **unconfirmed** (not shown as invented steps).

---

## Diagram (Mermaid swimlane-style)

```mermaid
flowchart TB
  subgraph Admin [Admin]
    A1[Create account — WM Seller Dist or Retailer]
    A2[Assign investment areas if Wealth Manager]
    A1 --> A2
  end

  subgraph User [User receiving access]
    U1[Enter mobile and password]
    U2{Credentials valid?}
    U3{Account blocked or deleted?}
    U4{Which application?}
    U5[WM app — area selection page]
    U6[Enter only authorised areas]
    U7[Seller app — dashboard]
    U8[Show invalid credentials]
    U9[Show blocked or deleted]
    U1 --> U2
    U2 -->|No| U8
    U2 -->|Yes| U3
    U3 -->|Yes| U9
    U3 -->|No| U4
    U4 -->|Wealth Manager app| U5 --> U6
    U4 -->|Seller app| U7
  end

  subgraph System [System]
    S1[Store account]
    S2[Authenticate]
    S3[Load authorised investment areas]
    S1 --> S2
    S2 --> S3
  end

  A2 --> S1
  U1 --> S2
  S3 --> U4
```

---

## PlantUML

See [../plantuml/swimlane-A.puml](../plantuml/swimlane-A.puml)
