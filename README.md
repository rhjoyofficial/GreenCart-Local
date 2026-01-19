# E-Commerce Multi-Vendor Management System

A role-based E-Commerce Multi-Vendor Management System built with **Laravel 12**, following **Software Engineering standards**. The system supports **Admin**, **Seller**, and **Customer** roles with secure authentication, product management, order processing, analytics, and reporting features.

---

## 📌 Project Overview

This project is designed to demonstrate practical implementation of:
- MVC Architecture
- Role-Based Access Control (RBAC)
- RESTful Routing
- Secure Authentication
- Modular System Design

The platform allows administrators to manage the entire system, sellers to manage their businesses, and customers to shop products seamlessly.

---

## 🧑‍💻 User Roles & Features

### 🔑 Admin
- Dashboard with analytics
- User & seller management
- Product approval and moderation
- Order management & invoice generation
- Category management
- Reports (Sales, Products, Sellers)
- System settings management

### 🏪 Seller
- Seller dashboard
- Product CRUD operations
- Activate/deactivate products
- Order status management
- Business profile & address management

### 🛒 Customer
- Product & category browsing
- Cart management
- Wishlist functionality
- Secure checkout & order placement
- Order history
- Profile & address management

---

## 🧱 System Architecture

- **Frontend:** Blade Templates + Tailwind CSS
- **Backend:** Laravel 12 (MVC Pattern)
- **Database:** MySQL
- **Authentication:** Laravel Auth with Role Middleware
- **Authorization:** Role-based access control (Admin, Seller, Customer)

---

## ⚙️ Technology Stack

| Layer        | Technology |
|--------------|------------|
| Backend      | Laravel 12, PHP 8.2 |
| Frontend     | Blade, Tailwind CSS |
| Database     | MySQL |
| Auth         | Laravel Breeze/Auth |
| Security     | Bcrypt, CSRF, Middleware |
| Version Ctrl | Git, GitHub |

---

## 🔐 Security Features

- Password hashing using **Bcrypt**
- Role-based middleware (`auth`, `role:admin/seller/customer`)
- CSRF protection on all forms
- Input validation using Laravel Requests

---

## 🧪 Testing

- Manual testing for all roles
- Route access testing
- CRUD operation testing
- Checkout & order flow testing

### Sample Tested Modules
- Authentication & authorization
- Product management
- Cart & checkout
- Order status updates

---

## 🚀 Installation & Setup

### 1️⃣ Clone the Repository
```bash
git clone https://github.com/your-username/ecommerce-multivendor.git
cd ecommerce-multivendor
````

### 2️⃣ Install Dependencies

```bash
composer install
npm install
```

### 3️⃣ Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` with your database credentials:

```env
DB_DATABASE=your_database
DB_USERNAME=root
DB_PASSWORD=
```

### 4️⃣ Database Migration & Seeding

```bash
php artisan migrate --seed
```

### 5️⃣ Run the Application

```bash
php artisan serve
npm run dev
```

Application URL:

```
http://127.0.0.1:8000
```

---

## 📂 Folder Structure (Important)

```
app/
 ├── Http/Controllers
 │   ├── Admin
 │   ├── Seller
 │   ├── Customer
 │   └── Frontend
routes/
 ├── web.php
resources/
 ├── views
 ├── css
 └── js
```

---

## 📦 Submission Instructions (Academic)

* ✅ Project Report (PDF/DOC)
* ✅ Video Demonstration (5 minutes)
* ✅ Full Source Code (exclude `node_modules`, `build`)
* ✅ README.md (this file)

---

## 📈 Future Improvements

* Online payment gateway integration
* REST API for mobile apps
* Real-time notifications
* Advanced analytics & recommendations

---

## 👤 Author

**Rakibul Hasan Joy**
BSc in Computer Science & Engineering
Northern University Bangladesh

---

## 📜 License

This project is developed for **academic purposes only**.
