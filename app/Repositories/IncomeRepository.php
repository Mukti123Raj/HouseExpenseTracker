<?php

namespace App\Repositories;

use App\Models\Income;

class IncomeRepository implements BaseRepository
{
    public function create(array $attributes)
    {
        return Income::create($attributes);
    }

    public function find($id)
    {
        return Income::find($id);
    }

    public function update($id, array $attributes)
    {
        $income = Income::find($id);
        if ($income) {
            $income->update($attributes);
            return $income;
        }
        return null;
    }

    public function delete($id)
    {
        $income = Income::find($id);
        if ($income) {
            return $income->delete();
        }
        return false;
    }
}