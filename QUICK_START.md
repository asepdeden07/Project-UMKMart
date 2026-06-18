# 🚀 UMKMart Quick Start Guide

## Setup Instructions

### Prerequisites

- PHP 8.4+
- Composer
- MySQL/MariaDB
- Laragon (Windows) or Local setup

### Installation

#### 1. Clone/Setup Project

```bash
cd c:\laragon\www\Project_pribadi\UMKMart
composer install
```

#### 2. Environment Configuration

```bash
cp .env.example .env
```

Update `.env` with your database:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=umkmart
DB_USERNAME=root
DB_PASSWORD=
```

#### 3. Generate App Key

```bash
php artisan key:generate
```

#### 4. Database Setup

```bash
# Run migrations
php artisan migrate

# Seed dummy data
php artisan db:seed

# Or fresh install with seed
php artisan migrate:fresh --seed
```

#### 5. Storage Link (for product images)

```bash
php artisan storage:link
```

#### 6. Start Development Server

```bash
php artisan serve
```

Visit: `http://localhost:8000`

---

## Login Credentials

### Admin

- Email: `admin@umkmart.test`
- Password: `password`
- Role: admin

### Customer

- Email: Any generated customer email
- Password: `password`
- Role: customer

---

## Quick Navigation

### Customer Dashboard

```
Home → /products
Cart → /cart
Checkout → /checkout
Orders → /orders
```

### Admin Dashboard

```
Dashboard → /admin/dashboard
Categories → /admin/categories
Products → /admin/products
Orders → /admin/orders
```

---

## Common Commands

```bash
# Database
php artisan migrate:fresh --seed      # Reset & seed
php artisan db:seed                   # Seed only
php artisan tinker                    # Interactive shell

# Caching
php artisan config:cache              # Cache config
php artisan route:cache               # Cache routes
php artisan view:cache                # Cache views

# Development
php artisan serve                     # Start server
php artisan make:model ModelName      # Create model
php artisan make:controller ControllerName
php artisan make:migration table_name

# Debugging
php artisan route:list                # Show all routes
php artisan route:list --path=admin   # Show admin routes
php artisan config:show               # Show configuration
```

---

## Project Structure Summary

```
app/
  ├── Http/Controllers/
  │   ├── Admin/          (product/order/category management)
  │   └── Customer/       (shopping, orders, cart)
  ├── Models/             (7 models: User, Product, Category, etc.)
  └── Http/Requests/      (7 form validation classes)

database/
  ├── factories/          (dummy data generators)
  ├── migrations/         (9 tables)
  └── seeders/            (populate database)

routes/
  ├── web.php             (main routes: 47 total)
  └── auth.php            (authentication routes)

storage/app/public/
  └── products/           (product image uploads)
```

---

## Authentication System

- **Method**: Laravel Breeze (session-based)
- **Password**: Hashed with bcrypt
- **Email Verification**: Enabled
- **Remember Me**: Supported

### Protected Routes

- Admin routes: require `auth` + `admin` middleware
- Customer routes: require `auth` + `customer` middleware
- Public routes: accessible to all

---

## Database Diagram Quick Reference

```
Users (admin/customer)
  ├─ many Carts (shopping cart)
  │   └─ many CartItems (product in cart)
  └─ many Orders (purchase orders)
      └─ many OrderItems (product in order)

Categories
  └─ many Products (product listings)
```

---

## Key Features at a Glance

✅ **Product Management**

- Browse products by category
- View product details
- Admin can add/edit/delete products
- Image upload support

✅ **Shopping Cart**

- Add products to cart
- Update quantities
- Remove items
- View cart total

✅ **Checkout Process**

- Secure transaction handling
- Stock verification
- Order creation
- Automatic cart clearing

✅ **Order Management**

- Customer can view order history
- Admin can view all orders
- Status tracking (pending → delivered)
- Order details with items

✅ **Admin Dashboard**

- Statistics overview
- Recent orders
- Top-selling products
- Low-stock alerts

---

## File Upload

### Product Image Upload

```
Location: storage/app/public/products/
Max Size: 2MB
Allowed: JPEG, PNG, JPG, GIF
```

### Accessing Uploaded Images

```
URL: /storage/products/{filename}
```

---

## Testing Scenarios

### Scenario 1: Complete Purchase

1. Login as customer
2. Browse products
3. Add items to cart
4. Update quantities
5. Proceed to checkout
6. Enter address & phone
7. Complete order
8. View order history

### Scenario 2: Admin Product Management

1. Login as admin
2. Go to Products
3. Create new product (with image)
4. Edit product
5. View in customer store
6. Delete product

### Scenario 3: Order Management

1. Login as admin
2. View all orders
3. Change order status (pending → confirmed → shipped → delivered)
4. View order details

---

## Performance Tips

- Product images are cached after first upload
- Use pagination (built-in for all lists)
- Admin dashboard shows top products (cached calculation)
- Database indexes on foreign keys and email

---

## Troubleshooting

**Can't login?**

- Clear browser cache
- Check user role in database
- Verify email verification (if enabled)

**Product images not showing?**

- Run: `php artisan storage:link`
- Check storage/app/public/products exists
- Verify file permissions (755 for folders)

**Database errors?**

- Verify .env DB credentials
- Check MySQL service is running
- Run: `php artisan migrate:fresh --seed`

**Port 8000 already in use?**

- `php artisan serve --port=8001`

---

## Next Steps

1. ✅ Review code in `app/` folder
2. ✅ Test all features as admin/customer
3. ✅ Create custom styling (CSS in resources/css)
4. ✅ Add views (currently using Laravel defaults)
5. ✅ Deploy to production

---

**Happy coding! 🎉**

For detailed architecture, see `ARCHITECTURE_GUIDE.md`  
For security best practices, see `SECURITY_BEST_PRACTICES.md`
