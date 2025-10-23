<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIncomeRequest;
use App\Services\IncomeService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IncomeController extends Controller
{
    protected $incomeService;

    public function __construct(IncomeService $incomeService)
    {
        $this->incomeService = $incomeService;
    }

    public function store(StoreIncomeRequest $request)
    {
        try {
            $income = $this->incomeService->createIncome($request->user(), $request->validated());
            
            return redirect()->route('dashboard')->with('success', 'Income added successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to add income. Please try again.'])->withInput();
        }
    }
}