# Quick Reference Commands

## Development Commands

### Start Servers

```bash
# Terminal 1 - Laravel
php artisan serve

# Terminal 2 - Vite (Vue compilation)
npm run dev
```

### Database Commands

```bash
# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Fresh migration (WARNING: Deletes all data)
php artisan migrate:fresh

# Seed database
php artisan db:seed

# Fresh migration with seed
php artisan migrate:fresh --seed
```

### Cache Commands

```bash
# Clear all cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Asset Commands

```bash
# Development build with hot reload
npm run dev

# Production build
npm run build

# Install dependencies
npm install
```

### Artisan Useful Commands

```bash
# List all routes
php artisan route:list

# Create new controller
php artisan make:controller NameController

# Create new model
php artisan make:model ModelName

# Create new migration
php artisan make:migration create_table_name

# Create new seeder
php artisan make:seeder TableSeeder

# Tinker (Laravel REPL)
php artisan tinker
```

### Git Commands for Portfolio

```bash
# Initialize repository
git init

# Add all files
git add .

# Commit changes
git commit -m "Initial commit: Personal Finance Tracker"

# Add remote repository
git remote add origin https://github.com/yourusername/finance-tracker.git

# Push to GitHub
git push -u origin main
```

## File Creation Checklist

### Backend Files (PHP)

-   [x] Migrations (categories, transactions, budgets)
-   [x] Models (Category, Transaction, Budget)
-   [x] Controllers (Dashboard, Transaction, Category, Budget)
-   [x] Routes (web.php)
-   [x] Seeder (DatabaseSeeder.php)

### Frontend Files (Vue)

**Components:**

-   [x] StatsCard.vue
-   [x] SpendingChart.vue
-   [x] TransactionList.vue
-   [x] BudgetProgress.vue

**Transaction Pages:**

-   [x] Transactions/Index.vue
-   [x] Transactions/Create.vue
-   [x] Transactions/Edit.vue

**Category Pages:**

-   [x] Categories/Index.vue
-   [x] Categories/Create.vue
-   [x] Categories/Edit.vue

**Budget Pages:**

-   [x] Budgets/Index.vue
-   [x] Budgets/Create.vue
-   [x] Budgets/Edit.vue

**Dashboard:**

-   [x] Dashboard.vue

### Configuration Files

-   [x] .env (database configuration)
-   [x] routes/web.php (routing)
-   [x] AuthenticatedLayout.vue (navigation update)

## Testing Checklist

### Authentication

-   [ ] Register new user
-   [ ] Login with credentials
-   [ ] Logout
-   [ ] Password reset

### Dashboard

-   [ ] View statistics cards
-   [ ] See spending chart
-   [ ] Check recent transactions
-   [ ] View budget progress

### Transactions

-   [ ] Create new income transaction
-   [ ] Create new expense transaction
-   [ ] Edit transaction
-   [ ] Delete transaction
-   [ ] Filter transactions
-   [ ] Search transactions
-   [ ] Test pagination

### Categories

-   [ ] Create income category
-   [ ] Create expense category
-   [ ] Edit category
-   [ ] Delete unused category
-   [ ] Verify cannot delete category with transactions

### Budgets

-   [ ] Create new budget
-   [ ] Edit budget amount
-   [ ] Delete budget
-   [ ] Change month/year
-   [ ] Verify spending calculation
-   [ ] Check over-budget warnings

## Deployment Checklist

### Pre-deployment

-   [ ] Update APP_ENV to production
-   [ ] Set APP_DEBUG to false
-   [ ] Generate new APP_KEY
-   [ ] Update database credentials
-   [ ] Configure proper MAIL settings
-   [ ] Set up HTTPS/SSL

### Build & Optimize

```bash
# Build assets
npm run build

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

### Database

```bash
# Run migrations on production
php artisan migrate --force

# Optionally seed demo data
php artisan db:seed --force
```

### Security

-   [ ] Enable HTTPS
-   [ ] Set secure session cookies
-   [ ] Configure CORS properly
-   [ ] Set up backup system
-   [ ] Enable rate limiting
-   [ ] Configure proper file permissions

### Post-deployment

-   [ ] Test all features
-   [ ] Verify database connections
-   [ ] Check error logs
-   [ ] Test authentication flow
-   [ ] Verify email functionality
-   [ ] Test responsive design

## Common Issues & Solutions

### Issue: Vite manifest not found

```bash
npm run build
```

### Issue: 419 Page Expired

```bash
php artisan config:clear
# Clear browser cookies
```

### Issue: Mixed Content (HTTP/HTTPS)

Update `.env`:

```env
APP_URL=https://yourdomain.com
```

### Issue: Database connection error

Verify `.env` database settings and restart server

### Issue: Permission denied

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## Portfolio Tips

### GitHub Repository

1. Add screenshots to README
2. Include demo link if deployed
3. Add detailed feature descriptions
4. Tag with relevant topics (laravel, vue, finance, portfolio)
5. Create releases for major versions

### Documentation

-   Explain architectural decisions
-   Document any custom solutions
-   Include setup instructions
-   Add API documentation if applicable

### Showcase Features

-   Real-time data updates
-   Interactive charts
-   Budget tracking algorithm
-   Responsive design
-   Clean code architecture

---

**Save this file as COMMANDS.md in your project root for quick reference!**
