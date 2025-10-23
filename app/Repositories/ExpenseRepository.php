<?php

namespace App\Repositories;

use App\Models\Expense;

class ExpenseRepository implements BaseRepository
{
    public function create(array $attributes)
    {
        return Expense::create($attributes);
    }

    public function find($id)
    {
        return Expense::find($id);
    }

    public function update($id, array $attributes)
    {
        $expense = Expense::find($id);
        if ($expense) {
            $expense->update($attributes);
            return $expense;
        }
        return null;
    }

    public function delete($id)
    {
        $expense = Expense::find($id);
        if ($expense) {
            return $expense->delete();
        }
        return false;
    }
}