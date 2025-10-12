<?php

namespace App\Repositories;

use App\Models\Household;
use Illuminate\Support\Str;

class HouseholdRepository implements BaseRepository
{
    public function create(array $attributes)
    {
        return Household::create([
            'name' => $attributes['name'],
            'household_code' => $attributes['household_code'] ?? $this->generateHouseholdCode(),
        ]);
    }

    public function find($id)
    {
        return Household::find($id);
    }

    public function update($id, array $attributes)
    {
        $household = $this->find($id);
        if ($household) {
            $household->update($attributes);
            return $household;
        }
        return null;
    }

    public function delete($id)
    {
        $household = $this->find($id);
        if ($household) {
            return $household->delete();
        }
        return false;
    }

    public function findByCode(string $code)
    {
        return Household::where('household_code', $code)->first();
    }

    private function generateHouseholdCode(): string
    {
        do {
            $code = 'FAM-' . strtoupper(Str::random(4));
        } while ($this->findByCode($code));

        return $code;
    }
}