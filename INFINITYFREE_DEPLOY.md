# InfinityFree Deployment Guide

## Production Environment

Use `env.infinityfree.example` as your reference and keep your real `.env` local or upload it carefully with your production values.

Required production values:

```env
CI_ENVIRONMENT = production
app.baseURL = ''

database.default.hostname = 'hostname'
database.default.database = 'database'
database.default.username = 'username'
database.default.password = 'your_database_password'
database.default.DBDriver = MySQLi
```

## Recommended Folder Layout

If InfinityFree lets you place folders outside `htdocs`, use this:

```text
account-root/
  app/
  system/
  vendor/
  writable/
  .env
  htdocs/
    index.php
    .htaccess
    favicon.ico
    robots.txt
    css/
    uploads/
```

In this layout, upload the contents of `public/` into `htdocs`.

## Fallback Layout

If everything must stay in `htdocs`, this project can still work because `public/index.php` has a fallback path resolver:

```text
htdocs/
  app/
  system/
  vendor/
  writable/
  index.php
  .htaccess
  .env
  css/
  uploads/
```

This is less secure, so use it only if the recommended layout is not possible.

## Public Files

Use these files in the web root:
- `public/index.php`
- `public/.htaccess`
- `public/favicon.ico`
- `public/robots.txt`
- `public/css/`
- `public/uploads/` if you rely on local public uploads

## Security Prep Already Applied

The project already includes:
- sensitive file blocking in `.htaccess`
- support for clean routes like `/browse`, `/login`, and `/user/dashboard`
- a public front controller that can locate `Paths.php` in both normal and shared-hosting layouts
- placeholder Cloudinary keys instead of committed secrets

## Before Going Live

1. Import the database into `if0_41651793_inventory_system_db`
2. Upload your files using one of the layouts above
3. Confirm `.env` contains the production database credentials
4. Visit:
   - `/browse`
   - `/login`
   - `/buyer/login`
5. Test buyer, staff, and admin flows

## If Something Breaks

Check in this order:
- `.env` values
- `app.baseURL`
- uploaded `vendor/` folder
- `writable/` folder presence
- whether `public/index.php` and `public/.htaccess` are the files actually in `htdocs`
