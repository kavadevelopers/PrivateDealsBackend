# Authentication & Authorization

## Guards & providers

Defined in `config/auth.php`:

| Guard | Driver | Provider model |
|-------|--------|----------------|
| `admin` | session | `UserAdminModel` |
| `investor` | session | `InvestorModel` |
| `partner` | session | `PartnerModel` |
| `startup` | session | `StartupModel` |
| `seller` | session | `SellerMasterModel` |
| `investor-api-guard` | sanctum | `InvestorModel` |
| `partner-api-guard` | sanctum | `PartnerModel` |
| `startup-api-guard` | sanctum | `StartupModel` |
| `seller-api-guard` | sanctum | `SellerMasterModel` |

Default guard: `admin` (`AUTH_GUARD`).

Investor/Partner/Startup/Seller models use Sanctum `HasApiTokens`.

---

## API authentication layers

### 1. Header token (almost all product APIs)

- Middleware: `ApiHeaderAuthMiddleware`
- Header: `headtoken`
- Store: `ApiTokenForHeaderAuthModel` (admin master UI: header token)
- Failure: HTTP **500** JSON `Unauthorized Request`
- Logging: `ApiLogModel` (skipped if `isdebug` header set)
- Other logged headers: `deviceid`, `devicetype`, `usertype`, `userid`, `authorization`, `app-version-code`

### 2. Sanctum bearer (per-user)

- `Authorization: Bearer {token}` after login
- Middleware: `auth:investor-api-guard` etc.

### 3. Other

| Middleware | Use |
|------------|-----|
| `ApiBasicAuthMiddleware` | `/api/external/*` sample |
| `ThirdPartyApiAuthMiddleware` | `/api/sandbox/external/*` + `tpThrottle` |
| `WhatsappBasicAuth` | defined; WhatsApp webhook auth currently commented |

### Google login (V2 investor)

- `GOOGLE_CLIENT_ID` / secret in env; `config/services.php` exposes client_id
- Endpoints: register complete with Google id_token; `login-google`

---

## Web authentication

Redirect middleware pairs per actor:

- `AdminRedirectIfAuthenticatedMiddleware` / `AdminRedirectIfNotAuthenticatedMiddleware`
- Same pattern for Investor, Partner, Startup

Admin permissions: alias `hasPermission` → `AdminPermissionsMiddleware` with string abilities in routes (e.g. `hasPermission:pre ipo transaction`).

Spatie package: `spatie/laravel-permission` (`config/permission.php`). Admin rights also involve `AdminRightsModel` — verify both when debugging access denials.

---

## MPIN

Investor apps use MPIN set at registration; `check-mpin` endpoints re-verify for sensitive actions.

---

## Things AI should not casually change

- HTTP status for bad `headtoken` (clients may key off 500)
- Guard names referenced throughout routes
- Permission strings without DB migration/seed updates

## Related

- [api/overview.md](../api/overview.md)
- [modules/admin.md](../modules/admin.md)
