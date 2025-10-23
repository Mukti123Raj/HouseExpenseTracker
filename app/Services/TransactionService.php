<?php

namespace App\Services;

use App\Models\User;
use App\Models\Income;
use App\Models\Expense;
use App\Repositories\IncomeRepository;
use App\Repositories\ExpenseRepository;
use Carbon\Carbon;

class TransactionService
{
    protected $incomeRepository;
    protected $expenseRepository;

    public function __construct(IncomeRepository $incomeRepository, ExpenseRepository $expenseRepository)
    {
        $this->incomeRepository = $incomeRepository;
        $this->expenseRepository = $expenseRepository;
    }

    public function getTransactions(User $user, string $startDate, string $endDate)
    {
        if (!$user->household_id) {
            return [
                'incomes' => collect(),
                'expenses' => collect()
            ];
        }

        $incomes = $this->incomeRepository->getByDateRange($user->household_id, $startDate, $endDate);
        $expenses = $this->expenseRepository->getByDateRange($user->household_id, $startDate, $endDate);

        return [
            'incomes' => $incomes,
            'expenses' => $expenses
        ];
    }

    public function updateIncome(Income $income, array $validatedData)
    {
        // Authorization check - ensure income belongs to user's household
        if (!$this->canModifyIncome($income)) {
            throw new \Exception('Unauthorized to modify this income record.');
        }

        return $this->incomeRepository->update($income->id, $validatedData);
    }

    public function deleteIncome(Income $income)
    {
        // Authorization check
        if (!$this->canModifyIncome($income)) {
            throw new \Exception('Unauthorized to delete this income record.');
        }

        return $this->incomeRepository->delete($income->id);
    }

    public function updateExpense(Expense $expense, array $validatedData)
    {
        // Authorization check - ensure expense belongs to user's household
        if (!$this->canModifyExpense($expense)) {
            throw new \Exception('Unauthorized to modify this expense record.');
        }

        return $this->expenseRepository->update($expense->id, $validatedData);
    }

    public function deleteExpense(Expense $expense)
    {
        // Authorization check
        if (!$this->canModifyExpense($expense)) {
            throw new \Exception('Unauthorized to delete this expense record.');
        }

        return $this->expenseRepository->delete($expense->id);
    }

    private function canModifyIncome(Income $income)
    {
        return auth()->user()->household_id === $income->household_id;
    }

    private function canModifyExpense(Expense $expense)
    {
        return auth()->user()->household_id === $expense->household_id;
    }
}
