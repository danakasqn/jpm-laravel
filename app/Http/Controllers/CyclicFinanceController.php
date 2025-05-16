<?php

namespace App\Http\Controllers;

use App\Models\CyclicFinance;
use App\Models\Mieszkanie;
use Illuminate\Http\Request;

class CyclicFinanceController extends Controller
{
    public function index()
    {
        $cyclicFinances = CyclicFinance::with('apartment')->latest()->get();
        $apartments = Mieszkanie::all();

        return view('cyclic_finances.index', compact('cyclicFinances', 'apartments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'due_day' => 'required|integer|min:1|max:31',
            'apartment_id' => 'nullable|exists:mieszkania,id',
        ]);

        CyclicFinance::create($request->only('title', 'type', 'due_day', 'apartment_id'));

        return redirect()->route('cyclic-finances.index')->with('success', 'Dodano cykliczny wpis.');
    }

    public function edit(CyclicFinance $cyclicFinance)
    {
        $apartments = Mieszkanie::all();

        return view('cyclic_finances.edit', compact('cyclicFinance', 'apartments'));
    }

    public function update(Request $request, CyclicFinance $cyclicFinance)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'due_day' => 'required|integer|min:1|max:31',
            'apartment_id' => 'nullable|exists:mieszkania,id',
        ]);

        $cyclicFinance->update($request->only('title', 'type', 'due_day', 'apartment_id'));

        return redirect()->route('cyclic-finances.index')->with('success', 'Zaktualizowano wpis.');
    }

    public function destroy(CyclicFinance $cyclicFinance)
    {
        $cyclicFinance->delete();

        return redirect()->route('cyclic-finances.index')->with('success', 'Usunięto wpis.');
    }
}
