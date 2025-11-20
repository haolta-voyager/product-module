# Product Module - Hướng dẫn cài đặt và sử dụng

## 📋 Tổng quan

1. **Quản lý Danh mục** (Categories - PostgreSQL)
2. **Quản lý Sản phẩm** (Products - MySQL) 
3. **Quản lý Đánh giá** (Reviews - MongoDB)

## 🚀 Cài đặt

### 1. Cấu hình Database trong .env

```env
# MySQL cho Products
MYSQL_CONNECTION=mysql
MYSQL_HOST=mysql
MYSQL_PORT=3306
MYSQL_DATABASE=product-module

PG_CONNECTION=pgsql
PG_HOST=postgres
PG_PORT=5432
PG_DATABASE=product-module

MONGO_CONNECTION=mongodb
MONGO_HOST=mongo
MONGO_PORT=27017
MONGO_DATABASE=product-module
```

### 2. Cài đặt dependencies

```bash
composer install
```

### 3. Chạy migration

```bash
# Chạy migration của Module (tất cả database)
php artisan module:migrate Product

# Hoặc chạy riêng từng database:
# PostgreSQL cho Categories
php artisan migrate --database=pgsql --path=Modules/Product/database/migrations

# MySQL cho Products  
php artisan migrate --database=mysql --path=Modules/Product/database/migrations

# MongoDB cho Reviews
php artisan migrate --database=mongodb --path=Modules/Product/database/migrations
```

### 4. Seed dữ liệu mẫu

```bash
# Chạy seeder của Module
php artisan module:seed Product

# Hoặc chạy trực tiếp seeder chính
php artisan db:seed --class="Modules\Product\Database\Seeders\ProductDatabaseSeeder"
```

**Dữ liệu mẫu sẽ được tạo:**
- 🟢 **6 Categories** (PostgreSQL): Điện thoại, Laptop, Tablet, Phụ kiện, Đồng hồ, Tai nghe
- 🔵 **14 Products** (MySQL): Các sản phẩm công nghệ đa dạng
- 🟡 **3-7 Reviews/Product** (MongoDB): Đánh giá thực tế với rating 1-5

### 5. Khởi chạy

```bash
# Development
composer dev

# Hoặc riêng lẻ
php artisan serve
npm run dev
```

## 🌐 Routes

- **Categories**: `/product/categories`
- **Products**: `/product/products`  
- **Reviews**: `/product/products/{product}/reviews`

## 🔧 Troubleshooting

### Lỗi kết nối database
- Kiểm tra cấu hình .env
- Đảm bảo các database service đã chạy

### Lỗi migration
```bash
php artisan config:clear
php artisan cache:clear
```

### Lỗi autoload
```bash
composer dump-autoload
```

## Hỗ trợ

Nếu gặp lỗi, vui lòng kiểm tra:
1. Log Laravel: `storage/logs/laravel.log`
2. Cấu hình database
3. Dependencies đã được cài đặt đầy đủ