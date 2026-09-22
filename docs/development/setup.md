# Development Setup

Follow root `README.md` plus:

1. PHP 8.3 recommended; tune `php.ini` upload/memory limits for large demat/PDFs.
2. Point Apache/Nginx vhost to `public/`.
3. `cp .env.example .env` and configure DB.
4. **Before first migrate:** temporarily comment `SettingServiceProvider` register/boot bodies if `app_settings` missing.
5. `composer install`
6. Set `FILESYSTEM_DISK` (`local` or `s3` + AWS vars).
7. `php artisan key:generate`
8. `php artisan migrate`
9. Restore `SettingServiceProvider`.
10. `php artisan optimize` as needed.
11. Run queue worker locally if testing notifications.
12. Create/obtain a valid `headtoken` row for API calls; use Sanctum token after login.

## Default superadmin (from README)

- Username: `shuruup`
- Password: `ShuruUp@123`  
  Change immediately on shared environments.

## Front-end assets

`package.json` is minimal; admin theme assets largely live under `public/assets`. Vite config exists — verify whether your workflow needs `npm` builds.

## Tests

`tests/` + PHPUnit 11 present; coverage of business flows may be thin — prefer manual API checks for transaction changes.

## Related

- [development/conventions.md](conventions.md)
- [configuration/environment.md](../configuration/environment.md)
