<?php

namespace App\Http\Controllers;

use App\Models\CyclicFinance;
use App\Models\Mieszkanie;
use App\Models\ExpenseType;
use Illuminate\Http\Request;
use App\Services\TaxService;

class CyclicFinanceController extends Controller
{
    public function index()
{
    $cyclicFinances = CyclicFinance::with(['apartment.residents', 'expenseType'])->latest()->get();

    $apartments = Mieszkanie::with(['residents' => fn($q) => $q->orderByDesc('created_at')])->get();

    $expenseTypes = ExpenseType::all();

    return view('cyclic_finances.index', compact('cyclicFinances', 'apartments', 'expenseTypes'));
}


    public function store(Request $request)
    {
        $request->validate([
            'expense_type_id' => 'required|exists:expense_types,id',
            'type' => 'required|in:Przychód,Wydatek',
            'due_day' => 'required|integer|min:1|max:31',
            'apartment_id' => 'nullable|exists:mieszkania,id',
            'amount' => 'nullable|numeric|min:0',
        ]);

        CyclicFinance::create($request->only('expense_type_id', 'type', 'due_day', 'apartment_id', 'amount'));

        return redirect()->route('cyclic-finances.index')->with('success', 'Dodano cykliczny wpis.');
    }

    public function edit(CyclicFinance $cyclicFinance)
    {
        $apartments = Mieszkanie::with('residents')->get();
        $expenseTypes = ExpenseType::all();

        return view('cyclic_finances.edit', compact('cyclicFinance', 'apartments', 'expenseTypes'));
    }

    public function update(Request $request, CyclicFinance $cyclicFinance)
    {
        $request->validate([
            'expense_type_id' => 'required|exists:expense_types,id',
            'type' => 'required|in:Przychód,Wydatek',
            'due_day' => 'required|integer|min:1|max:31',
            'apartment_id' => 'nullable|exists:mieszkania,id',
            'amount' => 'nullable|numeric|min:0',
        ]);

        $cyclicFinance->update($request->only('expense_type_id', 'type', 'due_day', 'apartment_id', 'amount'));

        return redirect()->route('cyclic-finances.index')->with('success', 'Zaktualizowano wpis.');
    }

    public function destroy(CyclicFinance $cyclicFinance)
    {
        $cyclicFinance->delete();
        return redirect()->route('cyclic-finances.index')->with('success', 'Usunięto wpis.');
    }

    public function urzadSkarbowy(Request $request)
    {
        $rok = $request->input('rok', now()->year);
        $miesiac = $request->input('miesiac', now()->subMonth()->month);

        $all = TaxService::getTaxBreakdownByLandlordAndApartment($rok, $miesiac);

        return view('cyclic_finances.urzad_skarbowy', compact('all', 'rok', 'miesiac'));
    }
}
