<?php
// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\Budget;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create demo user
        $user = User::create([
            'name' => 'Demo User',
            'email' => 'demo@example.com',
            'password' => Hash::make('password'),
        ]);

        // Create categories
        $incomeCategories = [
            ['name' => 'Salary', 'type' => 'income', 'color' => '#10B981', 'icon' => 'banknotes'],
            ['name' => 'Freelance', 'type' => 'income', 'color' => '#3B82F6', 'icon' => 'computer-desktop'],
            ['name' => 'Investment', 'type' => 'income', 'color' => '#8B5CF6', 'icon' => 'chart-bar'],
        ];

        $expenseCategories = [
            ['name' => 'Food & Dining', 'type' => 'expense', 'color' => '#F59E0B', 'icon' => 'cake'],
            ['name' => 'Transportation', 'type' => 'expense', 'color' => '#EF4444', 'icon' => 'truck'],
            ['name' => 'Shopping', 'type' => 'expense', 'color' => '#EC4899', 'icon' => 'shopping-bag'],
            ['name' => 'Entertainment', 'type' => 'expense', 'color' => '#6366F1', 'icon' => 'film'],
            ['name' => 'Bills & Utilities', 'type' => 'expense', 'color' => '#059669', 'icon' => 'bolt'],
            ['name' => 'Healthcare', 'type' => 'expense', 'color' => '#DC2626', 'icon' => 'heart'],
        ];

        $categories = [];
        foreach (array_merge($incomeCategories, $expenseCategories) as $categoryData) {
            $categoryData['user_id'] = $user->id;
            $categories[] = Category::create($categoryData);
        }

        // Create transactions for the last 3 months
        $transactions = [];
        $currentMonth = Carbon::now();

        for ($i = 2; $i >= 0; $i--) {
            $month = $currentMonth->copy()->subMonths($i);

            // Income transactions
            $salaryCategory = collect($categories)->firstWhere('name', 'Salary');
            Transaction::create([
                'user_id' => $user->id,
                'category_id' => $salaryCategory->id,
                'amount' => 5000,
                'description' => 'Monthly salary',
                'transaction_date' => $month->copy()->day(1),
                'type' => 'income',
            ]);

            // Random expense transactions
            $expenseCats = collect($categories)->where('type', 'expense');
            for ($j = 0; $j < rand(10, 20); $j++) {
                $category = $expenseCats->random();
                $amount = rand(10, 500);
                $day = rand(1, $month->daysInMonth);

                Transaction::create([
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'amount' => $amount,
                    'description' => $this->getRandomDescription($category->name),
                    'transaction_date' => $month->copy()->day($day),
                    'type' => 'expense',
                ]);
            }
        }

        // Create budgets for current month
        $currentMonth = Carbon::now();
        $budgetData = [
            'Food & Dining' => 800,
            'Transportation' => 300,
            'Shopping' => 400,
            'Entertainment' => 200,
            'Bills & Utilities' => 500,
        ];

        foreach ($budgetData as $categoryName => $amount) {
            $category = collect($categories)->firstWhere('name', $categoryName);
            if ($category) {
                Budget::create([
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'amount' => $amount,
                    'month' => $currentMonth->month,
                    'year' => $currentMonth->year,
                ]);
            }
        }

        $this->command->info('Demo data created successfully!');
        $this->command->info('Email: demo@example.com');
        $this->command->info('Password: password');
    }

    private function getRandomDescription($categoryName)
    {
        $descriptions = [
            'Food & Dining' => ['Grocery shopping', 'Restaurant dinner', 'Coffee shop', 'Fast food', 'Delivery'],
            'Transportation' => ['Gas station', 'Uber ride', 'Parking fee', 'Car maintenance', 'Public transport'],
            'Shopping' => ['Online shopping', 'Clothing store', 'Electronics', 'Home items', 'Gifts'],
            'Entertainment' => ['Movie tickets', 'Concert', 'Streaming service', 'Books', 'Games'],
            'Bills & Utilities' => ['Electric bill', 'Water bill', 'Internet', 'Phone bill', 'Rent'],
            'Healthcare' => ['Pharmacy', 'Doctor visit', 'Gym membership', 'Vitamins', 'Insurance'],
        ];

        $options = $descriptions[$categoryName] ?? ['Payment'];
        return $options[array_rand($options)];
    }
}
