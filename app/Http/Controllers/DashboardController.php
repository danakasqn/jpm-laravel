<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\Finance;
use App\Models\Mieszkanie;
use App\Models\CyclicFinance;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $soon = $today->copy()->addDays(14);
        $appStartDate = Carbon::create(2025, 5, 1)->startOfMonth();

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
            $startOfMonth = $currentMonth->copy()->startOfMonth()->toDateString();
            $endOfMonth = $currentMonth->copy()->endOfMonth()->toDateString();

            $cyclicFinances = CyclicFinance::with('apartment')
                ->get()
                ->filter(function ($cyclic) use ($startOfMonth, $endOfMonth) {
                    return !Finance::whereRaw('LOWER(kategoria) = ?', [strtolower($cyclic->title)])
                        ->where('typ', $cyclic->type === 'income' ? 'Przychód' : 'Wydatek')
                        ->where('apartment_id', $cyclic->apartment_id)
                        ->whereBetween('data', [$startOfMonth, $endOfMonth])
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
            ->sortBy(function ($item) {
                return $item['month']->copy()->setDay($item['cyclic']->due_day);
            })
            ->first();

        $nextDueDate = $nextDueDate
            ? $nextDueDate['month']->copy()->setDay($nextDueDate['cyclic']->due_day)->format('d.m.Y')
            : '—';

        // Statystyki bieżącego miesiąca
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $monthlyIncomes = Finance::where('typ', 'Przychód')
            ->whereDate('data', '>=', $startOfMonth)
            ->whereDate('data', '<=', $endOfMonth)
            ->sum('kwota');

        $monthlyExpenses = Finance::where('typ', 'Wydatek')
            ->whereDate('data', '>=', $startOfMonth)
            ->whereDate('data', '<=', $endOfMonth)
            ->sum('kwota');

        $monthlyProfit = $monthlyIncomes - $monthlyExpenses;

        $pendingCount = Finance::where('status', 'pending')
            ->whereMonth('data', $today->month)
            ->whereYear('data', $today->year)
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
            'nextDueDate'
        ));
    }
}
