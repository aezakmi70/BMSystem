<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    /**
     * Display a listing of the income for a specific date.
     */
    public function showIncomeByDate(Request $request)
    {
        // Validate the date input
        $validated = $request->validate([
            'date' => 'required|date',  // Ensure the date is a valid date format
        ]);

        // Fetch income records for the selected date
        $incomeRecords = Income::whereDate('date', $validated['date'])->get();

        // Return a view with the filtered income records
        return view('income.show', compact('incomeRecords'));
    }
}
