<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Household extends Model
{
    protected $fillable = ['name', 'household_code'];
    
    public function users()
    {
        return $this->hasMany(User::class);
    }
    
    public function incomes()
    {
        return $this->hasMany(Income::class);
    }
    
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
