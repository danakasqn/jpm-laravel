<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Finance;
use App\Models\Mieszkanie;
use Illuminate\Routing\Controller as BaseController;

class FinanceController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->_action === 'zapisz') {
            return $this->zapisz($request);
        }

        $userId = auth()->id();

        $query = Finance::with('apartment')->where('user_id', $userId);

        if ($request->filled('data')) {
            $query->whereDate('data', $request->data);
        }

        if ($request->filled('typ')) {
            $query->where('typ', $request->typ);
        }

        if ($request->filled('apartment_id')) {
            $query->where('apartment_id', $request->apartment_id);
        }

        if ($request->filled('kategoria')) {
            $query->where('kategoria', $request->kategoria);
        }

        if ($request->filled('notatka')) {
            $query->where('notatka', 'like', '%' . $request->notatka . '%');
        }

        if ($request->filled('kwota')) {
            $query->where('kwota', $request->kwota);
        }

        $finanse = $query->latest()->get();

        $sumaPrzychodow = $finanse->where('typ', 'Przychód')->sum('kwota');
        $sumaWydatkow = $finanse->where('typ', 'Wydatek')->sum('kwota');
        $bilans = $sumaPrzychodow - $sumaWydatkow;

        $apartments = Mieszkanie::all();

        return view('finanse.index', compact(
            'finanse',
            'sumaPrzychodow',
            'sumaWydatkow',
            'bilans',
            'apartments'
        ));
    }

    public function zapisz(Request $request)
    {
        $validated = $request->validate([
            'data' => 'required|date',
            'apartment_id' => 'required|exists:mieszkania,id',
            'typ' => 'required|in:Przychód,Wydatek',
            'kwota' => 'required|numeric',
            'kategoria' => 'nullable|string',
            'notatka' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        Finance::create($validated);

        return redirect()->route('finanse.index')->with('sukces', 'Dodano wpis.');
    }

    public function usun($id)
    {
        Finance::where('user_id', auth()->id())->where('id', $id)->delete();

        return redirect()->route('finanse.index')->with('sukces', 'Wpis usunięty.');
    }

    public function edytuj($id)
    {
        $rekord = Finance::where('user_id', auth()->id())->findOrFail($id);
        $apartments = Mieszkanie::all();

        return view('finanse.edytuj', compact('rekord', 'apartments'));
    }

    public function aktualizuj(Request $request, $id)
    {
        $rekord = Finance::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'data' => 'required|date',
            'apartment_id' => 'required|exists:mieszkania,id',
            'typ' => 'required|in:Przychód,Wydatek',
            'kwota' => 'required|numeric',
            'kategoria' => 'nullable|string',
            'notatka' => 'nullable|string',
        ]);

        $rekord->update($validated);

        return redirect()->route('finanse.index')->with('sukces', 'Rekord został zaktualizowany.');
    }
}
