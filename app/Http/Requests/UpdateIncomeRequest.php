<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIncomeRequest extends FormRequest
{
    public function authorize()
    {
        // Check if the income belongs to the user's household
        $income = $this->route('income');
        return $income && $income->household_id === auth()->user()->household_id;
    }

    public function rules()
    {
        return [
            'amount' => 'required|numeric|min:0.01|max:999999.99',
            'source' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'income_date' => 'required|date|before_or_equal:tomorrow'
        ];
    }
}
