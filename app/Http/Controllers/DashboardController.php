<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\Finance;
use App\Models\Mieszkanie;
use App\Models\CyclicFinance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $rangeType = $request->input('range_type', 'month'); // 'month' or 'year'
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        $today = Carbon::today();
        $appStartDate = Carbon::create(2025, 5, 1)->startOfMonth();
        $soon = $today->copy()->addDays(14);

        // Zakres daty
        if ($rangeType === 'year') {
            $startOfPeriod = Carbon::create($year)->startOfYear();
            $endOfPeriod = Carbon::create($year)->endOfYear();
        } else {
            $startOfPeriod = Carbon::create($year, $month)->startOfMonth();
            $endOfPeriod = Carbon::create($year, $month)->endOfMonth();
        }

        // Umowy kończące się w ciągu 14 dni
        $endingSoonResidents = Resident::with('apartment')
            ->whereNotNull('do_kiedy')
            ->whereBetween('do_kiedy', [$today, $soon])
            ->orderBy('do_kiedy')
            ->get();

        // Zaległe płatności cykliczne
        $missingCyclicFinances = collect();
        $currentMonth = $appStartDate->copy();
        $endMonth = $today->copy()->startOfMonth();

        while ($currentMonth->lte($endMonth)) {
            $start = $currentMonth->copy()->startOfMonth()->toDateString();
            $end = $currentMonth->copy()->endOfMonth()->toDateString();

            $cyclicFinances = CyclicFinance::with(['apartment', 'expenseType'])
                ->get()
                ->filter(function ($cyclic) use ($start, $end) {
                    return !Finance::where('typ', $cyclic->type === 'income' ? 'Przychód' : 'Wydatek')
                        ->where('apartment_id', $cyclic->apartment_id)
                        ->whereBetween('data', [$start, $end])
                        ->whereHas('expenseType', fn($q) =>
                            $q->whereRaw('LOWER(name) = ?', [strtolower(optional($cyclic->expenseType)->name)])
                        )
                        ->exists();
                })
                ->map(function ($cyclic) use ($currentMonth) {
                    return [
                        'cyclic' => $cyclic,
                        'month' => $currentMonth->copy()
                    ];
                });

            $missingCyclicFinances = $missingCyclicFinances->merge($cyclicFinances);
            $currentMonth->addMonth();
        }

        $nextDueDate = $missingCyclicFinances
            ->sortBy(fn($item) => $item['month']->copy()->setDay($item['cyclic']->due_day))
            ->first();

        $nextDueDate = $nextDueDate
            ? $nextDueDate['month']->copy()->setDay($nextDueDate['cyclic']->due_day)->format('d.m.Y')
            : '—';

        // Statystyki finansowe
        $monthlyIncomes = Finance::where('typ', 'Przychód')
            ->whereBetween('data', [$startOfPeriod, $endOfPeriod])
            ->sum('kwota');

        $monthlyExpenses = Finance::where('typ', 'Wydatek')
            ->whereBetween('data', [$startOfPeriod, $endOfPeriod])
            ->sum('kwota');

        $monthlyProfit = $monthlyIncomes - $monthlyExpenses;

        $pendingCount = Finance::where('status', 'pending')
            ->whereBetween('data', [$startOfPeriod, $endOfPeriod])
            ->count();

        $mieszkania = Mieszkanie::all();

        return view('dashboard', compact(
            'endingSoonResidents',
            'missingCyclicFinances',
            'monthlyIncomes',
            'monthlyExpenses',
            'monthlyProfit',
            'mieszkania',
            'pendingCount',
            'nextDueDate',
            'month',
            'year',
            'rangeType'
        ));
    }
}
