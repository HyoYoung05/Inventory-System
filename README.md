# Inventory System

A role-based inventory and storefront system built with CodeIgniter 4.

This project includes three user flows:
- `admin` for inventory oversight, users, categories, revenue, and order support
- `staff` for operational inventory visibility and order updates
- `buyer` for browsing, categories, cart, checkout, and order tracking

## Current Routes

- Public browse: `http://localhost:8080/browse`
- Buyer login: `http://localhost:8080/buyer/login`
- Buyer register: `http://localhost:8080/buyer/register`
- Admin or staff login: `http://localhost:8080/login`

After login:
- Admin: `/admin/dashboard`
- Staff: `/staff/dashboard`
- Buyer: `/user/dashboard`

## Main Features

- Role-based authentication for admin, staff, and buyer flows
- Public storefront with filters, product quick-view modals, and buyer-only purchase actions
- Buyer dashboard, categories page, cart, orders, and editable profile
- Admin dashboard with inventory metrics, revenue cards, sales charts, and recent orders
- Staff dashboard with inventory status visibility and order management
- Product image uploads with local storage fallback and optional Cloudinary support
- Order status flow:
  - `to_be_packed`
  - `to_be_shipped`
  - `to_be_delivered`
  - `completed`
  - `cancelled`

## Tech Stack

- PHP 8.2+
- CodeIgniter 4
- MySQL / MariaDB
- Bootstrap 5
- Bootstrap Icons
- Chart.js
- Optional Cloudinary image hosting

## Local Setup

1. Place the project in `c:\xampp\htdocs\inventory-system`
2. Start Apache and MySQL in XAMPP, or run the app with:

```bash
php spark serve
```

3. Use this base URL in both `.env` and `app/Config/App.php`:

```env
app.baseURL = 'http://localhost:8080/'
```

4. Configure your database in `.env`
5. Run migrations:

```bash
php spark migrate
```

6. Open:

```text
http://localhost:8080/
```

## Cloudinary Support

The app supports either of these env formats:

```env
cloudinary.cloudName = 'your_cloud_name'
cloudinary.apiKey = 'your_api_key'
cloudinary.apiSecret = 'your_api_secret'
cloudinary.folder = 'inventory-system/products'
```

or:

```env
CLOUDINARY_URL=cloudinary://API_KEY:API_SECRET@CLOUD_NAME
cloudinary.folder = 'inventory-system/products'
```

If Cloudinary is not configured, product uploads fall back to local storage in `public/uploads/products`.

## Project Structure

- `app/Controllers/` application flows
- `app/Models/` database models
- `app/Views/` UI templates
- `app/Database/Migrations/` schema changes
- `app/Database/Seeds/` optional starter data
- `public/` public entry and uploaded assets

## Important Before Uploading To GitHub

- Do not commit real secrets in `.env`
- Rotate any API keys or secrets that were shared or exposed during development
- Keep `.env` local and commit only safe examples or commented placeholders
- Verify your `app.baseURL` matches the environment you want to demo

## Notes

This repo has evolved beyond the default CodeIgniter starter, so the documentation here reflects the current inventory-store implementation rather than the original framework boilerplate.
