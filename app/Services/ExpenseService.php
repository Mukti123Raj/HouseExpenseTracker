<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\ExpenseRepository;

class ExpenseService
{
    protected $expenseRepository;

    public function __construct(ExpenseRepository $expenseRepository)
    {
        $this->expenseRepository = $expenseRepository;
    }

    public function createExpense(User $user, array $validatedData)
    {
        if (!$user->household_id) {
            throw new \Exception('User must be assigned to a household to create expenses.');
        }

        $data = array_merge($validatedData, [
            'user_id' => $user->id,
            'household_id' => $user->household_id
        ]);

        $expense = $this->expenseRepository->create($data);
        
        if (!$expense) {
            throw new \Exception('Failed to create expense.');
        }

        return $expense;
    }
}