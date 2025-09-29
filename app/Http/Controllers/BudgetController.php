<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class BudgetController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        $budgets = auth()->user()->budgets()
            ->with('category')
            ->where('month', $month)
            ->where('year', $year)
            ->get()
            ->map(function ($budget) use ($month, $year) {
                $spent = $budget->category->transactions()
                    ->where('user_id', auth()->id())
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

        $categories = auth()->user()->categories()
            ->where('type', 'expense')
            ->get();

        return Inertia::render('Budgets/Index', [
            'budgets' => $budgets,
            'categories' => $categories,
            'currentMonth' => $month,
            'currentYear' => $year,
        ]);
    }

    public function create()
    {
        $categories = auth()->user()->categories()
            ->where('type', 'expense')
            ->get();

        return Inertia::render('Budgets/Create', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2020',
        ]);

        // Verify category belongs to user and is expense type
        $category = Category::where('id', $validated['category_id'])
            ->where('user_id', auth()->id())
            ->where('type', 'expense')
            ->firstOrFail();

        // Check if budget already exists for this category/month/year
        $exists = Budget::where('user_id', auth()->id())
            ->where('category_id', $validated['category_id'])
            ->where('month', $validated['month'])
            ->where('year', $validated['year'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['category_id' => 'Budget already exists for this category and period.']);
        }

        $validated['user_id'] = auth()->id();
        Budget::create($validated);

        return redirect()->route('budgets.index')
            ->with('success', 'Budget created successfully.');
    }

    public function edit(Budget $budget)
    {
        if ($budget->user_id !== auth()->id()) {
            abort(404);
        }

        $categories = auth()->user()->categories()
            ->where('type', 'expense')
            ->get();

        return Inertia::render('Budgets/Edit', [
            'budget' => $budget->load('category'),
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Budget $budget)
    {
        if ($budget->user_id !== auth()->id()) {
            abort(404);
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $budget->update($validated);

        return redirect()->route('budgets.index')
            ->with('success', 'Budget updated successfully.');
    }

    public function destroy(Budget $budget)
    {
        if ($budget->user_id !== auth()->id()) {
            abort(404);
        }

        $budget->delete();

        return redirect()->route('budgets.index')
            ->with('success', 'Budget deleted successfully.');
    }
}
