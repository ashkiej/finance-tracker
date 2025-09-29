# Project Overview: Laravel Finance Tracker

This document provides a high-level overview of the project, its technical stack, and instructions on how to get it running for a demonstration.

## 1. What is this project?

This is a web-based personal finance tracker designed to help users monitor their income and expenses. Users can categorize transactions, set monthly or yearly budgets, and view their financial activity on a dashboard.

**Core Features:**
- **User Authentication:** Secure registration and login for users.
- **Dashboard:** An overview of recent transactions, spending by category (chart), and budget progress.
- **Transaction Management:** Users can add, edit, and delete transactions (both income and expenses).
- **Category Management:** Users can define their own spending/income categories.
- **Budgeting:** Users can set financial budgets for specific categories and time periods.

## 2. Technology Stack

This project is a modern web application built with the following technologies:

- **Backend:** **Laravel (PHP)** - A robust PHP framework that handles all business logic, data processing, and routing.
- **Frontend:** **Vue.js** - A progressive JavaScript framework for building the user interface.
- **Connector:** **Inertia.js** - Acts as a bridge between the Laravel backend and the Vue.js frontend. It allows for the creation of a single-page application (SPA) without building a separate API.
- **Styling:** **Tailwind CSS** - A utility-first CSS framework for rapid UI development.
- **Database:** The application is configured for a relational database (like MySQL, PostgreSQL, or SQLite) managed via Laravel's Eloquent ORM.

## 3. How to Run the Project (Demo Steps)

Follow these steps to set up and run the application locally.

### Prerequisites:
- PHP >= 8.2
- Composer (PHP package manager)
- Node.js & npm (or yarn)
- A local database server (e.g., MySQL, MariaDB)

### Step 1: Backend Setup
1.  **Copy Environment File:**
    ```bash
    cp .env.example .env
    ```
2.  **Install PHP Dependencies:**
    ```bash
    composer install
    ```
3.  **Generate Application Key:**
    ```bash
    php artisan key:generate
    ```
4.  **Configure Database:**
    Open the `.env` file and update the `DB_*` variables with your local database credentials.
    ```ini
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=finance_tracker
    DB_USERNAME=root
    DB_PASSWORD=
    ```
5.  **Run Database Migrations:**
    This will create all the necessary tables in your database.
    ```bash
    php artisan migrate
    ```

### Step 2: Frontend Setup
1.  **Install Node.js Dependencies:**
    ```bash
    npm install
    ```
2.  **Build Frontend Assets:**
    Run the development server, which will compile the assets and watch for changes.
    ```bash
    npm run dev
    ```

### Step 3: Run the Application
1.  **Start the Laravel Server:**
    Open a new terminal and run:
    ```bash
    php artisan serve
    ```
2.  **Access the Application:**
    Open your web browser and navigate to the URL provided by the `serve` command (usually `http://127.0.0.1:8000`).

### Demo Flow
1.  **Register:** Create a new user account.
2.  **Explore the Dashboard:** You will land on the main dashboard. It will be empty initially.
3.  **Create Categories:** Navigate to the "Categories" section and add a few spending categories (e.g., "Groceries", "Rent", "Entertainment").
4.  **Add Transactions:** Go to the "Transactions" section and add some income and expense transactions, assigning them to the categories you just created.
5.  **Set a Budget:** Go to the "Budgets" section and create a budget for one of your categories (e.g., a $500 monthly budget for "Groceries").
6.  **View Results:** Return to the dashboard to see the `SpendingChart` and `BudgetProgress` components update with your new data.
