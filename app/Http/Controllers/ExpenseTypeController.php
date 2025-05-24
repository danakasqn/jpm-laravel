<?php

namespace App\Http\Controllers;

use App\Models\ExpenseType;
use Illuminate\Http\Request;

class ExpenseTypeController extends Controller
{
    public function index()
    {
        $types = ExpenseType::orderBy('name')->get();
        return view('expense-types.index', compact('types'));
    }

    public function create()
    {
        return view('expense-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|in:Przychód,Wydatek',
            'category' => 'required|string|max:255',
        ]);

        ExpenseType::create([
            'name' => $request->input('name'),
            'category' => $request->input('category'),
            'taxable' => $request->has('taxable'),
        ]);

        return redirect()->route('settings.expense-types.index')
                         ->with('success', 'Typ operacji dodany.');
    }

    public function edit($typy_wydatkow)
    {
        $expenseType = ExpenseType::findOrFail($typy_wydatkow);
        return view('expense-types.edit', compact('expenseType'));
    }

    public function update(Request $request, $typy_wydatkow)
    {
        $request->validate([
            'name' => 'required|in:Przychód,Wydatek',
            'category' => 'required|string|max:255',
        ]);

        $expenseType = ExpenseType::findOrFail($typy_wydatkow);

        $expenseType->update([
            'name' => $request->input('name'),
            'category' => $request->input('category'),
            'taxable' => $request->has('taxable'),
        ]);

        return redirect()->route('settings.expense-types.index')
                         ->with('success', 'Typ operacji zaktualizowany.');
    }

    public function destroy($typy_wydatkow)
    {
        $expenseType = ExpenseType::findOrFail($typy_wydatkow);

        if ($expenseType->finances()->exists() || $expenseType->cyclicFinances()->exists()) {
            return redirect()->route('settings.expense-types.index')
                             ->with('error', 'Nie można usunąć – typ jest powiązany z finansami.');
        }

        $expenseType->delete();

        return redirect()->route('settings.expense-types.index')
                         ->with('success', 'Typ operacji usunięty.');
    }
}
