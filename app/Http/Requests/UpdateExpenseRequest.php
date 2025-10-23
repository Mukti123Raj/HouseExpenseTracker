<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExpenseRequest extends FormRequest
{
    public function authorize()
    {
        // Check if the expense belongs to the user's household
        $expense = $this->route('expense');
        return $expense && $expense->household_id === auth()->user()->household_id;
    }

    public function rules()
    {
        return [
            'amount' => 'required|numeric|min:0.01|max:999999.99',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'expense_date' => 'required|date|before_or_equal:tomorrow'
        ];
    }
}
