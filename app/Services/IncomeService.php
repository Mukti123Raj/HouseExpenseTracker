<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\IncomeRepository;

class IncomeService
{
    protected $incomeRepository;

    public function __construct(IncomeRepository $incomeRepository)
    {
        $this->incomeRepository = $incomeRepository;
    }

    public function createIncome(User $user, array $validatedData)
    {
        if (!$user->household_id) {
            throw new \Exception('User must be assigned to a household to add income.');
        }

        $data = array_merge($validatedData, [
            'user_id' => $user->id,
            'household_id' => $user->household_id
        ]);

        $income = $this->incomeRepository->create($data);
        
        if (!$income) {
            throw new \Exception('Failed to add income.');
        }

        return $income;
    }
}