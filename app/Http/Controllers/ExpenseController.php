<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Services\ExpenseService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExpenseController extends Controller
{
    protected $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }

    public function store(StoreExpenseRequest $request)
    {
        try {
            $expense = $this->expenseService->createExpense($request->user(), $request->validated());
            
            return redirect()->route('dashboard')->with('success', 'Expense created successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create expense. Please try again.'])->withInput();
        }
    }
}