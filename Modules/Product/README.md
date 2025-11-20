# Product Management Module

Ứng dụng quản lý sản phẩm được xây dựng theo kiến trúc Laravel Modules với 3 database khác nhau.

## Kiến Trúc

### Database Connections
- **MySQL**: Lưu trữ Products và Users
- **PostgreSQL**: Lưu trữ Categories  
- **MongoDB**: Lưu trữ Reviews

### Cấu Trúc Code (Tuân Thủ Clean Architecture)

#### 1. **Controller Layer** (≤150 dòng)
- CHỈ làm 3 việc: Validate (qua FormRequest) → Gọi Service → Trả Response
- CẤM logic nghiệp vụ, query database trực tiếp
- Files: `ProductController`, `CategoryController`, `ReviewController`

#### 2. **Service Layer** (Business Logic)
- Chứa TOÀN BỘ logic nghiệp vụ
- KHÔNG trả HTTP Response, chỉ trả dữ liệu (DTO, Model, array...)
- Files: `ProductService`, `CategoryService`, `ReviewService`

#### 3. **Repository Layer** (Data Access)
- Chứa các query phức tạp, có thể tái sử dụng
- Files: `ProductRepository`, `CategoryRepository`, `ReviewRepository`

#### 4. **DTO Layer** (Data Transfer Objects)
- Truyền dữ liệu có cấu trúc giữa các lớp
- CẤM dùng associative arrays
- Files: `ProductData`, `CategoryData`, `ReviewData`

#### 5. **Model Layer**
- CHỈ định nghĩa: properties, fillable, casts, relations
- CẤM logic nghiệp vụ
- Files: `Product`, `Category`, `Review`, `User`

#### 6. **Enums**
- `UserRole`: USER, CUSTOMER
- `Rating`: ONE, TWO, THREE, FOUR, FIVE

### Phân Quyền

#### User Role (user@example.com / password)
- **Có thể**: CRUD Products, CRUD Categories
- **Không thể**: Write Reviews

#### Customer Role (customer@example.com / password)
- **Có thể**: Xem Products, Write & Delete Reviews
- **Không thể**: CRUD Products/Categories

## Setup Instructions

### 1. Cài đặt dependencies
```bash
composer install
npm install
```

### 2. Cấu hình .env
File `.env` đã được cấu hình với 3 connections:
- MySQL (products, users)
- PostgreSQL (categories)
- MongoDB (reviews)

### 3. Run migrations
```bash
php artisan migrate
php artisan module:migrate Product
php artisan module:migrate User
```

### 4. Seed database
```bash
php artisan db:seed
```

Dữ liệu mẫu:
- 3 users (1 user role, 2 customer roles)
- 5 categories
- 5 products
- 3 reviews

### 5. Start server
```bash
php artisan serve
```

Truy cập: http://localhost:8000

## API Endpoints

### Public Routes
- `GET /products` - Danh sách sản phẩm
- `GET /products/{id}` - Chi tiết sản phẩm
- `GET /categories` - Danh sách categories

### User Routes (Yêu cầu role = 'user')
- `GET /products/create` - Form tạo sản phẩm
- `POST /products` - Tạo sản phẩm mới
- `GET /products/{id}/edit` - Form sửa sản phẩm
- `PUT /products/{id}` - Cập nhật sản phẩm
- `DELETE /products/{id}` - Xóa sản phẩm

- `GET /categories/create` - Form tạo category
- `POST /categories` - Tạo category
- `PUT /categories/{id}` - Cập nhật category
- `DELETE /categories/{id}` - Xóa category

### Customer Routes (Yêu cầu role = 'customer')
- `GET /products/{productId}/reviews` - Xem reviews
- `POST /reviews` - Tạo review
- `DELETE /reviews/{id}` - Xóa review

## Quy Tắc Code Đã Áp Dụng

### 1. Dependency Injection
- CẤM dùng `new` trong Controller/Service
- CẤM dùng static helpers (`Auth::user()`, `Request::input()`)
- CẤM inject Model trực tiếp
- PHẢI inject qua constructor

### 2. Coding Style
- **DRY**: Không lặp code
- **KISS**: Giữ code đơn giản
- **Guard Clauses**: Return sớm, tránh lồng >3 cấp
- **Modern PHP**: Dùng Enum, match, typed properties, null-safe operator

### 3. Constants
- Định nghĩa trong Enum/Class liên quan
- CẤM class CommonConstants chung chung

## Testing Accounts

```
User (Quản lý CRUD):
Email: user@example.com
Password: password

Customer (Chỉ review):
Email: customer@example.com
Password: password
```

## Module Structure

```
Modules/Product/
├── app/
│   ├── DTOs/
│   │   ├── ProductData.php
│   │   ├── CategoryData.php
│   │   └── ReviewData.php
│   ├── Enums/
│   │   └── Rating.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ProductController.php
│   │   │   ├── CategoryController.php
│   │   │   └── ReviewController.php
│   │   ├── Middleware/
│   │   │   ├── CheckUserRole.php
│   │   │   └── CheckCustomerRole.php
│   │   └── Requests/
│   │       ├── StoreProductRequest.php
│   │       ├── UpdateProductRequest.php
│   │       ├── StoreCategoryRequest.php
│   │       └── StoreReviewRequest.php
│   ├── Models/
│   │   ├── Product.php
│   │   ├── Category.php
│   │   └── Review.php
│   ├── Repositories/
│   │   ├── ProductRepository.php
│   │   ├── CategoryRepository.php
│   │   └── ReviewRepository.php
│   └── Services/
│       ├── ProductService.php
│       ├── CategoryService.php
│       └── ReviewService.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── layouts/
│       ├── products/
│       ├── categories/
│       └── reviews/
└── routes/
    └── web.php
```

## Tech Stack

- **Laravel 11**
- **nwidart/laravel-modules**
- **MongoDB Laravel Package**
- **Tailwind CSS** (via CDN)
- **PHP 8.1+** (Enums, Constructor Property Promotion)
