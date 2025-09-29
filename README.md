# 💰 Personal Finance Tracker

A modern, full-stack personal finance management application built with Laravel 11+ and Vue.js 3.

![Laravel](https://img.shields.io/badge/Laravel-11+-FF2D20?style=flat&logo=laravel&logoColor=white)
![Vue.js](https://img.shields.io/badge/Vue.js-3-4FC08D?style=flat&logo=vue.js&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind-3-38B2AC?style=flat&logo=tailwind-css&logoColor=white)
![Inertia.js](https://img.shields.io/badge/Inertia.js-Latest-9553E9?style=flat)

## 📸 Screenshots

[Add your screenshots here]

## ✨ Features

-   📊 **Interactive Dashboard** - Visual overview of your finances with charts and statistics
-   💸 **Transaction Management** - Track income and expenses with detailed categorization
-   🏷️ **Custom Categories** - Create and manage personalized category systems
-   🎯 **Budget Tracking** - Set monthly budgets and monitor spending limits
-   📈 **Real-time Analytics** - Spending breakdowns and financial insights
-   🔐 **Secure Authentication** - User registration and login with Laravel Breeze
-   🎨 **Modern UI** - Clean, responsive design with Tailwind CSS
-   ⚡ **Fast & Smooth** - SPA experience powered by Inertia.js

## 🛠️ Tech Stack

### Backend

-   **Laravel 11+** - PHP framework
-   **MySQL** - Database
-   **Inertia.js** - Server-side routing

### Frontend

-   **Vue.js 3** - Progressive JavaScript framework
-   **Tailwind CSS** - Utility-first CSS framework
-   **Chart.js** - Data visualization
-   **Vite** - Build tool

## 🚀 Installation

### Prerequisites

-   PHP 8.2+
-   Composer
-   Node.js 18+
-   MySQL

### Setup Steps

1. **Clone the repository**

```bash
git clone https://github.com/yourusername/finance-tracker.git
cd finance-tracker
```

2. **Install PHP dependencies**

```bash
composer install
```

3. **Install JavaScript dependencies**

```bash
npm install
```

4. **Environment configuration**

```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure database**
   Update `.env` with your database credentials:

```env
DB_DATABASE=finance_tracker
DB_USERNAME=root
DB_PASSWORD=your_password
```

6. **Run migrations**

```bash
php artisan migrate
```

7. **Seed demo data (optional)**

```bash
php artisan db:seed
```

8. **Start development servers**

Terminal 1:

```bash
php artisan serve
```

Terminal 2:

```bash
npm run dev
```

9. **Access application**
   Open browser: `http://localhost:8000`

**Demo credentials:**

-   Email: demo@example.com
-   Password: password

## 📁 Project Structure

```
finance-tracker/
├── app/
│   ├── Http/Controllers/      # Application controllers
│   └── Models/                # Eloquent models
├── database/
│   ├── migrations/            # Database migrations
│   └── seeders/               # Database seeders
├── resources/
│   └── js/
│       ├── Components/        # Reusable Vue components
│       ├── Layouts/           # Layout components
│       └── Pages/             # Page components
└── routes/
    └── web.php                # Application routes
```

## 🎯 Key Functionality

### Dashboard

-   Financial overview with income, expenses, and balance
-   Interactive spending chart by category
-   Recent transactions list
-   Budget progress tracking

### Transactions

-   Create, read, update, and delete transactions
-   Filter by category, type, and search term
-   Pagination for large datasets
-   Date-based tracking

### Categories

-   Manage income and expense categories
-   Color-coded organization
-   Visual icons for quick identification
-   Prevent deletion of categories in use

### Budgets

-   Set monthly spending limits per category
-   Real-time spending tracking
-   Visual progress indicators
-   Over-budget warnings

## 🔒 Security

-   CSRF protection
-   SQL injection prevention via Eloquent ORM
-   Password hashing with bcrypt
-   Input validation and sanitization
-   User data isolation

## 🌐 Browser Support

-   Chrome (latest)
-   Firefox (latest)
-   Safari (latest)
-   Edge (latest)

## 📝 License

This project is open-source and available under the MIT License.

## 🤝 Contributing

Contributions, issues, and feature requests are welcome!

## 📧 Contact

Your Name - your.email@example.com

Project Link: [https://github.com/yourusername/finance-tracker](https://github.com/yourusername/finance-tracker)

---

**⭐ Star this repository if you find it helpful!**
