<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\Budget;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $currentDate = Carbon::now();
        $month = $currentDate->month;
        $year = $currentDate->year;
        // Get current month transactions
        $transactions = $user->transactions()
            ->with('category')
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Calculate totals
        $totalIncome = $user->transactions()
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->where('type', 'income')
            ->sum('amount');

        $totalExpenses = $user->transactions()
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->where('type', 'expense')
            ->sum('amount');

        // Get spending by category for chart
        $spendingByCategory = $user->transactions()
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.type', 'expense')
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->selectRaw('categories.name, categories.color, SUM(transactions.amount) as total')
            ->groupBy('categories.id', 'categories.name', 'categories.color')
            ->get();

        // Get budget vs actual
        $budgets = $user->budgets()
            ->with('category')
            ->where('month', $month)
            ->where('year', $year)
            ->get()
            ->map(function ($budget) use ($month, $year, $user) {
                $spent = $budget->category->transactions()
                    ->where('user_id', $user->id)
                    ->where('type', 'expense')
                    ->whereMonth('transaction_date', $month)
                    ->whereYear('transaction_date', $year)
                    ->sum('amount');

                return [
                    'id' => $budget->id,
                    'category' => $budget->category,
                    'amount' => $budget->amount,
                    'spent' => $spent,
                    'remaining' => $budget->amount - $spent,
                    'percentage' => $budget->amount > 0 ? ($spent / $budget->amount) * 100 : 0,
                ];
            });

        return Inertia::render('Dashboard', [
            'stats' => [
                'totalIncome' => $totalIncome,
                'totalExpenses' => $totalExpenses,
                'balance' => $totalIncome - $totalExpenses,
                'transactionCount' => $transactions->count(),
            ],
            'recentTransactions' => $transactions,
            'spendingByCategory' => $spendingByCategory,
            'budgets' => $budgets,
        ]);
    }
}
