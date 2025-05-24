<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Finance;
use App\Models\Mieszkanie;
use App\Models\CyclicFinance;
use App\Models\ExpenseType;
use App\Services\TaxService;
use App\Services\FinanceReminderService;

class FinanceController extends Controller
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

        $query = Finance::with(['apartment', 'expenseType']);

        // Wykonuj filtrowanie TYLKO gdy GET zawiera typowe pola do filtrowania
        if ($request->hasAny(['data_od', 'data_do', 'typ', 'expense_type_id', 'notatka', 'kwota'])) {
    // uwaga! apartment_id NIE powoduje już filtrowania

            if ($request->filled('data')) $query->whereDate('data', $request->data);
            if ($request->filled('typ')) $query->where('typ', $request->typ);
            if ($request->filled('apartment_id')) $query->where('apartment_id', $request->apartment_id);
            if ($request->filled('expense_type_id')) $query->where('expense_type_id', $request->expense_type_id);
            if ($request->filled('notatka')) $query->where('notatka', 'like', '%' . $request->notatka . '%');
            if ($request->filled('kwota')) $query->where('kwota', $request->kwota);
            if ($request->filled('data_od')) $query->whereDate('data', '>=', $request->data_od);
            if ($request->filled('data_do')) $query->whereDate('data', '<=', $request->data_do);
        }

        $finanse = $query->latest()->get();
        $sumaPrzychodow = $finanse->where('typ', 'Przychód')->sum('kwota');
        $sumaWydatkow = $finanse->where('typ', 'Wydatek')->sum('kwota');
        $bilans = $sumaPrzychodow - $sumaWydatkow;

        $apartments = Mieszkanie::all();
        $typyOperacji = ExpenseType::pluck('name')->unique();

        // Dane do wstępnego uzupełnienia formularza (np. z „Dodaj wpis”)
        $prefill = $request->only([
            'typ', 'kwota', 'data', 'apartment_id', 'expense_type_id', 'notatka'
        ]);

        return view('finanse.formularz', compact(
            'finanse', 'sumaPrzychodow', 'sumaWydatkow', 'bilans',
            'apartments', 'typyOperacji', 'prefill'
        ));
    }

    public function zapisz(Request $request)
    {
        $validated = $request->validate([
            'data' => 'required|date',
            'apartment_id' => 'required|exists:mieszkania,id',
            'typ' => 'required|in:Przychód,Wydatek',
            'kwota' => 'required|numeric',
            'expense_type_id' => 'required|exists:expense_types,id',
            'notatka' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        $validated['wynajmujacy'] = Mieszkanie::with('residents')
            ->find($validated['apartment_id'])?->residents->last()?->wynajmujacy;

        Finance::create($validated);

        return redirect()->route('finanse.formularz')->with('sukces', 'Dodano wpis.');
    }

    public function edytuj($id)
    {
        $rekord = Finance::where('user_id', auth()->id())->findOrFail($id);
        $apartments = Mieszkanie::all();
        $expenseTypes = ExpenseType::all();

        return view('finanse.edytuj', compact('rekord', 'apartments', 'expenseTypes'));
    }

    public function aktualizuj(Request $request, $id)
    {
        $rekord = Finance::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'data' => 'required|date',
            'apartment_id' => 'required|exists:mieszkania,id',
            'typ' => 'required|in:Przychód,Wydatek',
            'kwota' => 'required|numeric',
            'expense_type_id' => 'required|exists:expense_types,id',
            'notatka' => 'nullable|string',
        ]);

        $validated['wynajmujacy'] = Mieszkanie::with('residents')
            ->find($validated['apartment_id'])?->residents->last()?->wynajmujacy;

        $rekord->update($validated);

        return redirect()->route('finanse.operacje')->with('sukces', 'Rekord został zaktualizowany. Operacje zaktualizowane.');
    }

    public function usun($id)
    {
        Finance::where('user_id', auth()->id())->where('id', $id)->delete();
        return redirect()->route('finanse.formularz')->with('sukces', 'Wpis usunięty.');
    }

    public function oznaczJakoWykonane($id)
    {
        $rekord = Finance::findOrFail($id);
        $rekord->update(['status' => 'done']);
        return redirect()->route('finanse.operacje')->with('sukces', 'Operacja oznaczona jako wykonana.');
    }

    public function operacjeDoWykonania()
    {
        $pending = FinanceReminderService::getPendingOperations();
        return view('finanse.operacje', ['pending' => $pending]);
    }

    public function urzadSkarbowy(Request $request)
    {
        $rok = $request->input('rok', now()->year);
        $miesiac = $request->input('miesiac', now()->subMonth()->month);
        $wybranyWynajmujacy = $request->input('wynajmujacy');

        $all = TaxService::getTaxSummaryByLandlord($rok, $miesiac);

        if ($wybranyWynajmujacy) {
            $all = array_filter($all, fn($_, $key) => $key === $wybranyWynajmujacy, ARRAY_FILTER_USE_BOTH);
        }

        $data = [];

        foreach ($all as $landlord => $row) {
            $data[] = [
                'wynajmujacy' => $landlord,
                'rok' => $rok,
                'miesiac' => ucfirst(now()->createFromDate($rok, $miesiac, 1)->locale('pl')->translatedFormat('F')),
                'suma' => $row['suma'],
                'czesc_85' => $row['czesc_85'],
                'czesc_125' => $row['czesc_125'],
                'podatek' => $row['podatek'],
            ];
        }

        $dostepniWynajmujacy = array_keys($all);

        return view('cyclic_finances.urzad_skarbowy', compact(
            'data', 'rok', 'miesiac', 'dostepniWynajmujacy', 'wybranyWynajmujacy'
        ));
    }
}
