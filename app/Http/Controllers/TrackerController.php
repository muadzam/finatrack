<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use App\Models\Saving;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TrackerController extends Controller
{
    public function dashboard(Request $request)
    {
        $filter = $request->get('filter', 'overall');
        $month = $request->get('month');

        $startDate = null;
        $endDate = null;

        if ($filter === 'month' && $month) {
            $startDate = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
            $endDate = Carbon::createFromFormat('Y-m', $month)->endOfMonth();
        }

        $incomeData = Income::when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
            return $query->whereBetween('date', [$startDate, $endDate]);
        })->selectRaw(
            "CASE
            WHEN source = 'Others' THEN COALESCE(other_source, 'Unspecified')
            ELSE source
        END as source_label,
        SUM(amount) as total_amount"
        )->groupBy('source_label')->get();

        $expenseData = Expense::when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
            return $query->whereBetween('date', [$startDate, $endDate]);
        })->get();

        $savingData = Saving::when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
            return $query->whereBetween('date', [$startDate, $endDate]);
        })->get();

        // Calculate Totals
        $totalIncome = $incomeData->sum('total_amount');
        $totalExpenses = $expenseData->sum('amount');
        $totalSavings = $savingData->sum('amount');

        // Calculate Leftover
        $leftover = $totalIncome - ($totalExpenses + $totalSavings);

        return view('dashboard', compact(
            'incomeData',
            'expenseData',
            'savingData',
            'totalIncome',
            'totalExpenses',
            'totalSavings',
            'leftover',
            'filter',
            'month'
        ));
    }

    public function incomeForm(){
        return view('income');
    }

    public function storeIncome(Request $request)
    {
        $request->validate([
            'source' => 'required|string',
            'other_source' => 'nullable|string',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date_format:Y-m',
        ]);

        $date = $request->input('date') . '-01';

        // Save income
        Income::create([
            'source' => $request->input('source'),
            'other_source' => $request->input('other_source'),
            'amount' => $request->input('amount'),
            'date' => $date,
        ]);

        return redirect()->route('dashboard')->with('success', 'Income added successfully');
    }

    public function expenseForm(){
        return view('expense');
    }

    public function storeExpense(Request $request)
    {
        $request->validate([
            'source' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date_format:Y-m',
        ]);

        $date = $request->input('date') . '-01';

        // Save expense
        Expense::create([
            'source' => $request->input('source'),
            'amount' => $request->input('amount'),
            'date' => $date,
        ]);

        return redirect()->route('dashboard')->with('success', 'Expense added successfully');
    }

    public function savingForm(){
        return view('saving');
    }

    public function storeSaving(Request $request)
    {
        $request->validate([
            'source' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date_format:Y-m',
        ]);

        $date = $request->input('date') . '-01';

        // Save saving
        Saving::create([
            'source' => $request->input('source'),
            'amount' => $request->input('amount'),
            'date' => $date,
        ]);

        return redirect()->route('dashboard')->with('success', 'Saving added successfully');
    }
}
