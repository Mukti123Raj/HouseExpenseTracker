<?php

namespace App\Services;

use App\Models\User;
use App\Models\Income;
use App\Models\Expense;
use Carbon\Carbon;

class DashboardService
{
    /**
     * Get dashboard data for a user
     *
     * @param User $user
     * @return array
     */
    public function getDashboardData(User $user): array
    {
        $household = $user->household;
        
        if (!$household) {
            return [
                'monthlySummary' => [
                    'totalIncome' => 0,
                    'totalExpenses' => 0,
                    'remainingBalance' => 0,
                ],
                'latestIncome' => null,
                'latestExpense' => null,
            ];
        }
        
        // Calculate start and end dates for current month
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        
        // Calculate total income for the month
        $totalIncome = $household->incomes()
            ->whereBetween('income_date', [$startDate, $endDate])
            ->sum('amount');
            
        // Calculate total expenses for the month
        $totalExpenses = $household->expenses()
            ->whereBetween('expense_date', [$startDate, $endDate])
            ->sum('amount');
            
        // Calculate remaining balance
        $remainingBalance = $totalIncome - $totalExpenses;
        
        // Get latest income with user
        $latestIncome = $household->incomes()
            ->with('user:id,name')
            ->latest('income_date')
            ->first();
            
        // Get latest expense with user
        $latestExpense = $household->expenses()
            ->with('user:id,name')
            ->latest('expense_date')
            ->first();
            
        return [
            'monthlySummary' => [
                'totalIncome' => $totalIncome,
                'totalExpenses' => $totalExpenses,
                'remainingBalance' => $remainingBalance,
            ],
            'latestIncome' => $latestIncome,
            'latestExpense' => $latestExpense,
        ];
    }
}