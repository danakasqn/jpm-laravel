<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Finance;
use App\Models\Mieszkanie;
use App\Models\CyclicFinance;
use Illuminate\Routing\Controller as BaseController;

class FinanceController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return redirect()->route('finanse.formularz');
    }

    public function formularz(Request $request)
    {
        if ($request->_action === 'zapisz') {
            return $this->zapisz($request);
        }

        $query = Finance::with('apartment');

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

        if ($request->filled('data_od')) {
            $query->whereDate('data', '>=', $request->data_od);
        }

        if ($request->filled('data_do')) {
            $query->whereDate('data', '<=', $request->data_do);
        }

        $finanse = $query->latest()->get();

        $sumaPrzychodow = $finanse->where('typ', 'Przychód')->sum('kwota');
        $sumaWydatkow = $finanse->where('typ', 'Wydatek')->sum('kwota');
        $bilans = $sumaPrzychodow - $sumaWydatkow;

        $apartments = Mieszkanie::all();

        return view('finanse.formularz', compact(
            'finanse',
            'sumaPrzychodow',
            'sumaWydatkow',
            'bilans',
            'apartments'
        ));
    }

    public function operacjeDoWykonania()
    {
        $today = now();
        $start = $today->copy()->startOfMonth()->toDateString();
        $end = $today->copy()->endOfMonth()->toDateString();

        $missingCyclicFinances = CyclicFinance::with('apartment')
            ->get()
            ->filter(function ($cyclic) use ($start, $end) {
                return !Finance::whereRaw('LOWER(kategoria) = ?', [strtolower($cyclic->title)])
                    ->where('typ', $cyclic->type === 'income' ? 'Przychód' : 'Wydatek')
                    ->where('apartment_id', $cyclic->apartment_id)
                    ->whereBetween('data', [$start, $end])
                    ->exists();
            })
            ->map(function ($cyclic) use ($today) {
                return (object)[
                    'typ' => $cyclic->type === 'income' ? 'Przychód' : 'Wydatek',
                    'kwota' => 0,
                    'kategoria' => $cyclic->title,
                    'data' => $today->copy()->setDay(min($cyclic->due_day, $today->daysInMonth))->toDateString(),
                    'apartment' => $cyclic->apartment,
                    'id' => null
                ];
            });

        return view('finanse.operacje', ['pending' => $missingCyclicFinances]);
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
        $validated['status'] = 'pending';

        Finance::create($validated);

        return redirect()->route('finanse.formularz')->with('sukces', 'Dodano wpis.');
    }

    public function usun($id)
    {
        Finance::where('user_id', auth()->id())->where('id', $id)->delete();

        return redirect()->route('finanse.formularz')->with('sukces', 'Wpis usunięty.');
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

        return redirect()->route('finanse.formularz')->with('sukces', 'Rekord został zaktualizowany.');
    }

    public function oznaczJakoWykonane($id)
    {
        $rekord = Finance::findOrFail($id);
        $rekord->update(['status' => 'done']);

        return redirect()->route('finanse.operacje')->with('sukces', 'Operacja oznaczona jako wykonana.');
    }
}
