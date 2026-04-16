# UI Overview

## Application Areas

### 1. Public Browse
Route: `/browse`

Used for:
- public product browsing
- filtering by category and price range
- product quick-view modals
- login or register prompts for guests

### 2. Buyer Area
Routes under `/user/*`

Pages:
- `/user/dashboard`
- `/user/categories`
- `/user/cart`
- `/user/orders`
- `/user/profile`

Buyer features:
- marketplace-style dashboard
- category-first browsing inside the authenticated area
- cart and buy-now flows
- order tracking and cancellation for eligible orders
- profile editing and password change

### 3. Admin Area
Routes under `/admin/*`

Pages include:
- dashboard
- inventory
- categories
- users
- orders

Admin features:
- total products, orders, low stock, out of stock, and revenue cards
- 7-day and 6-month sales charts
- recent orders table
- inventory quantity management
- product creation with image upload
- category and user management

### 4. Staff Area
Routes under `/staff/*`

Pages include:
- dashboard
- inventory
- orders

Staff features:
- inventory visibility only
- low stock and out-of-stock monitoring
- order status updates
- no revenue or sales chart access
- no quantity adjustment actions

## Buyer Navigation

Current buyer sidebar structure:
- Dashboard
- Browse
- Categories
- Cart
- My Orders
- Profile access from the sidebar user block

## Order Status Labels

The app uses these fulfillment states:
- To Be Packed
- To Be Shipped
- To Be Delivered
- Completed
- Cancelled

## Visual Patterns

Shared patterns across buyer pages:
- dark left sidebar
- card-based layouts
- product quick-view modals
- consistent Add to Cart and Buy Now placement
- responsive grids and tables

## Notes

The current UI is no longer the original starter layout. It is a custom inventory-store app with separate buyer, staff, and admin experiences.
