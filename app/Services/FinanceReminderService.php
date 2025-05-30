<?php

namespace App\Services;

use App\Models\CyclicFinance;
use App\Models\Finance;
use App\Models\Mieszkanie;
use Illuminate\Support\Collection;
use App\Services\TaxService;
use Illuminate\Support\Facades\Log;

class FinanceReminderService
{
    public static function getPendingOperations(): Collection
    {
        $today = now();
        $start = $today->copy()->startOfMonth()->toDateString();
        $end = $today->copy()->endOfMonth()->toDateString();
        $dzien = $today->day;
        $lastMonth = $today->copy()->subMonth();
        $pending = collect();

        // 📊 Oblicz podatek PPE za poprzedni miesiąc
        $podatki = TaxService::getTaxSummaryByLandlord($today->year, $lastMonth->month);

        foreach ($podatki as $landlord => $dane) {
            $incomes = Finance::whereRaw('LOWER(TRIM(wynajmujacy)) = ?', [trim(mb_strtolower($landlord))])
                ->where('typ', 'Przychód')
                ->whereYear('data', $today->year)
                ->whereMonth('data', $lastMonth->month)
                ->whereHas('expenseType', fn($q) => $q->where('taxable', true))
                ->get()
                ->filter(fn($entry) => $entry->apartment_id !== null)
                ->groupBy('apartment_id');

            foreach ($incomes as $apartmentId => $entries) {
                $mieszkanie = Mieszkanie::with('residents')->find($apartmentId);
                $suma = $entries->sum('kwota');
                $udzial = $dane['suma'] > 0 ? $suma / $dane['suma'] : 0;
                $kwotaPodatku = round($udzial * $dane['podatek'], 2); // <- teraz do dwóch miejsc

                // 💬 Debug log
                Log::debug('📊 Podatek naliczony', [
                    'landlord' => $landlord,
                    'apartment_id' => $apartmentId,
                    'suma_lokalu' => $suma,
                    'udzial' => $udzial,
                    'kwotaPodatku' => $kwotaPodatku,
                ]);

                if ($kwotaPodatku <= 0) continue;

                $cyclic = CyclicFinance::with('expenseType')
                    ->whereHas('expenseType', fn($q) => $q->where('name', 'Urząd Skarbowy'))
                    ->where('apartment_id', $apartmentId)
                    ->first();

                $expenseType = $cyclic?->expenseType;

                if ($cyclic && $expenseType) {
                    $czyIstnieje = Finance::where('typ', 'Wydatek')
                        ->where('expense_type_id', $expenseType->id)
                        ->where('apartment_id', $apartmentId)
                        ->whereBetween('data', [$start, $end])
                        ->exists();

                    if (!$czyIstnieje) {
                        $pending->push((object)[
                            'typ' => 'Wydatek',
                            'kwota' => $kwotaPodatku,
                            'kategoria' => $expenseType->name,
                            'expense_type_id' => $expenseType->id,
                            'expenseType' => $expenseType,
                            'data' => $today->copy()->setDay(min($cyclic->due_day, $today->daysInMonth))->toDateString(),
                            'apartment' => $mieszkanie,
                            'id' => null,
                            'tax_suggestion' => true,
                        ]);
                    }
                }
            }
        }

        // 🔁 Inne przypomnienia cykliczne (czynsz, media itp.)
        $cykliczne = CyclicFinance::with(['apartment', 'expenseType'])
            ->where('due_day', '<=', $dzien + 10)
            ->whereHas('expenseType', fn($q) => $q->where('name', '!=', 'Urząd Skarbowy'))
            ->get();

        foreach ($cykliczne as $cykliczny) {
    $expenseTypeId = optional($cykliczny->expenseType)->id;

    if (!$expenseTypeId) continue;

    $czyIstnieje = Finance::where('typ', $cykliczny->type)
        ->where('expense_type_id', $expenseTypeId)
        ->where('apartment_id', $cykliczny->apartment_id)
        ->whereBetween('data', [$start, $end])
        ->exists();

    if (!$czyIstnieje) {
        $kwota = (float) $cykliczny->amount;

        // ✅ Jeśli to Urząd Skarbowy – podmień kwotę na dynamiczną
        if (strtolower($cykliczny->expenseType->category) === 'urząd skarbowy') {
            $landlord = null;

if ($cykliczny->apartment && $cykliczny->apartment->residents->isNotEmpty()) {
    $landlord = $cykliczny->apartment->residents->first()->wynajmujacy;
}
            $apartmentId = $cykliczny->apartment_id;

            $taxData = TaxService::getTaxBreakdownByLandlordAndApartment($today->year, $lastMonth->month);
            $kwota = collect($taxData[$landlord]['mieszkania'] ?? [])
                ->firstWhere('apartment_id', $apartmentId)['podatek'] ?? 0;
        }

        $pending->push((object)[
            'typ' => $cykliczny->type,
            'kwota' => round($kwota, 2),
            'kategoria' => $cykliczny->expenseType->category,
            'expense_type_id' => $expenseTypeId,
            'expenseType' => $cykliczny->expenseType,
            'data' => $today->toDateString(),
            'apartment' => $cykliczny->apartment,
            'id' => null,
            'tax_suggestion' => strtolower($cykliczny->expenseType->category) === 'urząd skarbowy',
        ]);
    }
        }

        return $pending;
    }
}
