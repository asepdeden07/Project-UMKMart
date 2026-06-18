# 🏗️ UMKMart Architecture & Implementation Guide

## Project Overview

UMKMart adalah mini marketplace/mini Alfagift untuk UMKM (Usaha Mikro Kecil Menengah) berbasis Laravel 12.

**Key Features:**

- Product catalog management
- Shopping cart system
- Order management
- Role-based access (Admin/Customer)
- Order status tracking
- Inventory management

---

## Database Architecture

### Entity Relationship Diagram

```
┌─────────────┐
│    Users    │
├─────────────┤
│ id (PK)     │
│ name        │
│ email       │
│ password    │
│ role        │  ◄─────────────┐
│ timestamps  │                │
└─────────────┘                │
     │                         │
     ├─ hasMany ──────┐        │
     │                │        │
     ▼                ▼        │
┌─────────────┐  ┌─────────────┐
│   Carts     │  │   Orders    │
├─────────────┤  ├─────────────┤
│ id (PK)     │  │ id (PK)     │
│ user_id*    │  │ user_id*    ├──┬─ owner_id
│ timestamps  │  │ total_price │  │
└─────────────┘  │ status      │  │
     │           │ address     │  │
     │           │ phone       │  │
     │           │ notes       │  │
     │           │ timestamps  │  │
     │           └─────────────┘  │
     │                │           │
     ├─ hasMany ──┐   │ hasMany   │
     │            │   │           │
     ▼            ▼   ▼           │
┌──────────────────────────────┐ │
│      CartItems               │ │
├──────────────────────────────┤ │
│ id (PK)                      │ │
│ cart_id* (FK)                │ │
│ product_id* (FK) ────┐       │ │
│ quantity             │       │ │
│ price (snapshot)     │       │ │
│ timestamps           │       │ │
└──────────────────────┼───────┘ │
                       │         │
                       │    ┌────┴─────────────────────────┐
                       │    │                               │
                       ▼    ▼                               ▼
                   ┌────────────────┐  ┌──────────────────────────┐
                   │    Products    │  │    OrderItems            │
                   ├────────────────┤  ├──────────────────────────┤
                   │ id (PK)        │  │ id (PK)                  │
                   │ category_id*   │  │ order_id* (FK)           │
                   │ name           │  │ product_id* (FK)         │
                   │ slug           │  │ quantity                 │
                   │ description    │  │ price (snapshot)         │
                   │ price          │  │ subtotal                 │
                   │ stock          │  │ timestamps               │
                   │ image          │  └──────────────────────────┘
                   │ timestamps     │
                   └────────┬────────┘
                            │
                            │ belongsTo
                            │
                            ▼
                   ┌────────────────┐
                   │   Categories   │
                   ├────────────────┤
                   │ id (PK)        │
                   │ name           │
                   │ slug           │
                   │ timestamps     │
                   └────────────────┘
```

---

## Folder Structure

```
laravel-project/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php      (statistics)
│   │   │   │   ├── CategoryController.php       (product categories)
│   │   │   │   ├── ProductController.php        (inventory CRUD)
│   │   │   │   └── OrderController.php          (order management)
│   │   │   └── Customer/
│   │   │       ├── ProductController.php        (product browsing)
│   │   │       ├── CartController.php           (shopping cart)
│   │   │       ├── CheckoutController.php       (order creation)
│   │   │       └── OrderController.php          (order history)
│   │   ├── Middleware/
│   │   │   ├── IsAdmin.php                      (admin authorization)
│   │   │   └── IsCustomer.php                   (customer authorization)
│   │   └── Requests/
│   │       ├── StoreCategoryRequest.php
│   │       ├── UpdateCategoryRequest.php
│   │       ├── StoreProductRequest.php
│   │       ├── UpdateProductRequest.php
│   │       ├── AddToCartRequest.php
│   │       ├── CheckoutRequest.php
│   │       └── UpdateOrderStatusRequest.php
│   └── Models/
│       ├── User.php
│       ├── Category.php
│       ├── Product.php
│       ├── Cart.php
│       ├── CartItem.php
│       ├── Order.php
│       └── OrderItem.php
├── database/
│   ├── factories/
│   │   ├── UserFactory.php
│   │   ├── CategoryFactory.php
│   │   ├── ProductFactory.php
│   │   └── OrderFactory.php
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2025_01_02_000003_create_categories_table.php
│   │   ├── 2025_01_03_000004_create_products_table.php
│   │   ├── 2025_01_04_000005_create_carts_table.php
│   │   ├── 2025_01_05_000006_create_cart_items_table.php
│   │   ├── 2025_01_06_000007_create_orders_table.php
│   │   └── 2025_01_07_000008_create_order_items_table.php
│   └── seeders/
│       └── DatabaseSeeder.php
├── routes/
│   ├── web.php                                   (main routes)
│   ├── auth.php                                  (authentication)
│   └── console.php
├── storage/
│   └── app/
│       └── public/
│           └── products/                         (product images)
└── ...other Laravel files...
```

---

## API Routes Reference

### Public Routes

```
GET  /products                  → Show all products
GET  /products/{product:slug}   → Show product detail
```

### Customer Routes (Protected by `auth` & `customer` middleware)

```
GET  /cart                      → View shopping cart
POST /cart/add                  → Add product to cart
PATCH /cart/{cartItem}          → Update cart item quantity
DELETE /cart/{cartItem}         → Remove item from cart

GET  /checkout                  → Show checkout form
POST /checkout                  → Process order creation

GET  /orders                    → List customer's orders
GET  /orders/{order}            → Show order detail
```

### Admin Routes (Protected by `auth` & `admin` middleware)

```
GET  /admin/dashboard           → View statistics dashboard

# Categories
GET    /admin/categories        → List categories
GET    /admin/categories/create → Show create form
POST   /admin/categories        → Create category
GET    /admin/categories/{cat}  → Show category detail
GET    /admin/categories/{cat}/edit → Show edit form
PUT    /admin/categories/{cat}  → Update category
DELETE /admin/categories/{cat}  → Delete category

# Products
GET    /admin/products          → List products
GET    /admin/products/create   → Show create form
POST   /admin/products          → Create product
GET    /admin/products/{prod}   → Show product detail
GET    /admin/products/{prod}/edit → Show edit form
PUT    /admin/products/{prod}   → Update product
DELETE /admin/products/{prod}   → Delete product

# Orders
GET    /admin/orders            → List all orders
GET    /admin/orders/{order}    → Show order detail
PATCH  /admin/orders/{order}/status → Update order status
```

---

## Key Models & Methods

### User

```php
User::with('carts', 'orders')->get()
$user->isAdmin()        // boolean
$user->isCustomer()     // boolean
$user->carts()          // relationship
$user->orders()         // relationship
```

### Product

```php
$product->isOutOfStock()        // boolean
$product->isLowStock($threshold = 5)  // boolean
$product->category              // belongsTo Category
$product->cartItems             // hasMany CartItem
$product->orderItems            // hasMany OrderItem
```

### Cart

```php
$cart->getTotal()       // sum(price * quantity)
$cart->getItemCount()   // count of items
$cart->isEmpty()        // boolean
$cart->clear()          // delete all items
$cart->items            // hasMany CartItem
```

### Order

```php
// Scopes
Order::pending()->get()
Order::confirmed()->get()
Order::shipped()->get()
Order::delivered()->get()
Order::cancelled()->get()

// Methods
$order->isPending()     // boolean
$order->isConfirmed()
$order->isShipped()
$order->isDelivered()
$order->isCancelled()
$order->canBeCancelled()   // check current status
$order->getItemCount()  // count of items in order
```

---

## Business Logic Flows

### 1. Add to Cart Flow

```
Customer views product
Customer clicks "Add to Cart"
↓
Validate: product exists, quantity 1-999
↓
Check: product has stock
↓
If cart item exists: update quantity
Else: create new cart item
↓
Store price snapshot at this moment
↓
Show success message
```

### 2. Checkout Flow (Transaction-Wrapped)

```
Customer enters address, phone, notes
↓
Validate form fields
↓
Start DB transaction
  ├─ Lock product rows: lockForUpdate()
  ├─ Verify all products have stock
  ├─ Deduct stock from all products
  ├─ Create Order record
  ├─ Create OrderItems (with snapshots)
  └─ Clear customer's cart
↓
Commit transaction
↓
Show success, redirect to order detail
```

### 3. Admin Order Status Update Flow

```
Admin selects new status
↓
Validate transition is allowed:
  pending → confirmed, cancelled
  confirmed → shipped, cancelled
  shipped → delivered
  delivered → (no change)
  cancelled → (no change)
↓
Update order status
↓
Show success message
```

---

## Common Development Tasks

### Add New Product Field

1. Create migration: `php artisan make:migration add_field_to_products`
2. Add column to `up()` method
3. Add to Product model `$fillable`
4. Update form requests
5. Update controller
6. Run migration: `php artisan migrate`

### Add New Admin Feature

1. Create controller: `php artisan make:controller Admin/NewFeatureController`
2. Create model (if needed)
3. Add routes in `routes/web.php` with `middleware('admin')`
4. Add form requests for validation
5. Create views

### Generate Fresh Data

```bash
# Full reset with seed
php artisan migrate:fresh --seed

# Seed only (keep structure)
php artisan db:seed
```

### View Application State

```bash
# Start Tinker
php artisan tinker

# Query examples
User::where('role', 'admin')->first()
Product::with('category')->get()
Order::where('status', 'pending')->get()
```

---

## Testing with Dummy Data

After seeding, you can test:

**Admin Account:**

- Email: `admin@umkmart.test`
- Password: `password`

**Customer Accounts:**

- Email: auto-generated (check database)
- Password: `password`

**Sample Data:**

- 5 Categories
- 30 Products
- 10 Customers
- 20 Sample Orders

---

## Production Deployment

See `SECURITY_BEST_PRACTICES.md` for complete deployment checklist.

Key steps:

```bash
# 1. Set environment to production
APP_ENV=production
APP_DEBUG=false

# 2. Run migrations
php artisan migrate --force

# 3. Seed initial data (optional)
php artisan db:seed

# 4. Optimize
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Configure web server (Nginx/Apache)
# 6. Set up SSL certificate
# 7. Configure file permissions
```

---

## Troubleshooting

### Product images not showing

- Check `storage/app/public/products` exists
- Run `php artisan storage:link`
- Verify image path in database

### "Class not found" errors

- Run `composer dump-autoload`
- Check class namespaces match file location

### "Column not found" errors

- Run pending migrations: `php artisan migrate`
- Verify migration files created correctly

### Database connection errors

- Check `.env` DB credentials
- Verify MySQL/MariaDB service running
- Create database: `php artisan db:create` (Laravel 11+)

---

## Next Steps & Future Enhancements

### Phase 2: Customer Features

- [ ] Product reviews & ratings
- [ ] Wishlist/favorites
- [ ] User profile management
- [ ] Address book

### Phase 3: Admin Features

- [ ] Detailed analytics & reports
- [ ] Email notifications
- [ ] Bulk product import/export
- [ ] Discount/coupon system

### Phase 4: Payment Integration

- [ ] Payment gateway (Stripe, Midtrans)
- [ ] Invoice generation
- [ ] Refund management

### Phase 5: Advanced Features

- [ ] Multi-vendor support
- [ ] Shipping integration
- [ ] API for mobile app
- [ ] Real-time notifications

---

**Last Updated**: January 2025  
**Laravel Version**: 12  
**PHP Version**: 8.4+  
**Status**: ✅ MVP Ready
