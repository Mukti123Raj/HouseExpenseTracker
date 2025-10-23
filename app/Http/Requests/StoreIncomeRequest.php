<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIncomeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
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