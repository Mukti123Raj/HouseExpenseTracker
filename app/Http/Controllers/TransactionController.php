<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateIncomeRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Income;
use App\Models\Expense;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function index(Request $request)
    {
        $user = $request->user();
        
        // Validate and set date range (default to current month)
        $startDate = $request->get('startDate', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('endDate', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Validate dates
        $request->validate([
            'startDate' => 'nullable|date',
            'endDate' => 'nullable|date|after_or_equal:startDate'
        ]);

        $transactions = $this->transactionService->getTransactions($user, $startDate, $endDate);

        return Inertia::render('Transactions', [
            'incomes' => $transactions['incomes'],
            'expenses' => $transactions['expenses'],
            'initialStartDate' => $startDate,
            'initialEndDate' => $endDate
        ]);
    }

    public function updateIncome(UpdateIncomeRequest $request, Income $income)
    {
        try {
            $this->transactionService->updateIncome($income, $request->validated());
            
            return redirect()->back()->with('success', 'Income updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroyIncome(Request $request, Income $income)
    {
        try {
            // Additional authorization check
            if ($income->household_id !== $request->user()->household_id) {
                return redirect()->back()->withErrors(['error' => 'Unauthorized to delete this income record.']);
            }

            $this->transactionService->deleteIncome($income);
            
            return redirect()->back()->with('success', 'Income deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function updateExpense(UpdateExpenseRequest $request, Expense $expense)
    {
        try {
            $this->transactionService->updateExpense($expense, $request->validated());
            
            return redirect()->back()->with('success', 'Expense updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroyExpense(Request $request, Expense $expense)
    {
        try {
            // Additional authorization check
            if ($expense->household_id !== $request->user()->household_id) {
                return redirect()->back()->withErrors(['error' => 'Unauthorized to delete this expense record.']);
            }

            $this->transactionService->deleteExpense($expense);
            
            return redirect()->back()->with('success', 'Expense deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}

