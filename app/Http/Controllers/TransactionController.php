<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $transactions = $user->transactions()
            ->with('category')
            ->when($request->category_id, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($request->type, function ($query, $type) {
                $query->where('type', $type);
            })
            ->when($request->search, function ($query, $search) {
                $query->where('description', 'like', '%' . $search . '%');
            })
            ->orderBy('transaction_date', 'desc')
            ->paginate(15);

        $categories = $user->categories()->get();

        return Inertia::render('Transactions/Index', [
            'transactions' => $transactions,
            'categories' => $categories,
            'filters' => $request->only(['category_id', 'type', 'search']),
        ]);
    }

    public function create()
    {
        $categories = auth()->user()->categories()->get();

        return Inertia::render('Transactions/Create', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => [
                'required',
                \Illuminate\Validation\Rule::exists('categories', 'id')->where('user_id', $request->user()->id)
            ],
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
            'transaction_date' => 'required|date',
            'type' => 'required|in:income,expense',
        ]);

        $category = Category::find($validated['category_id']);
        $validated['type'] = $category->type;

        $request->user()->transactions()->create($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction created successfully.');
    }

    public function edit(Transaction $transaction)
    {
        // Ensure transaction belongs to user
        if ($transaction->user_id !== auth()->id()) {
            abort(404);
        }

        $categories = auth()->user()->categories()
            ->where('type', $transaction->type)
            ->get();

        return Inertia::render('Transactions/Edit', [
            'transaction' => $transaction->load('category'),
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Transaction $transaction)
    {
        // Ensure transaction belongs to user
        if ($transaction->user_id !== auth()->id()) {
            abort(404);
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
            'transaction_date' => 'required|date',
        ]);

        // Verify category belongs to user and matches type
        $category = Category::where('id', $validated['category_id'])
            ->where('user_id', auth()->id())
            ->where('type', $transaction->type)
            ->firstOrFail();

        $transaction->update($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction updated successfully.');
    }

    public function destroy(Transaction $transaction)
    {
        // Ensure transaction belongs to user
        if ($transaction->user_id !== auth()->id()) {
            abort(404);
        }

        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction deleted successfully.');
    }
}
