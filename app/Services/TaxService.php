<?php

namespace App\Services;

use App\Models\Finance;
use Illuminate\Support\Carbon;

class TaxService
{
    public static function getTaxSummaryByLandlord(int $rok, int $miesiac): array
    {
        $summary = [];

        $entries = Finance::with('expenseType')
            ->where('typ', 'Przychód')
            ->whereYear('data', $rok)
            ->whereMonth('data', $miesiac)
            ->whereHas('expenseType', fn($q) => $q->where('taxable', true))
            ->whereNotNull('wynajmujacy')
            ->get()
            ->groupBy(fn($entry) => trim(mb_strtolower($entry->wynajmujacy)));

        foreach ($entries as $group) {
            $displayName = $group->first()->wynajmujacy ?? '—';
            $suma = $group->sum('kwota');
            $czesc_85 = min($suma, 100000) * 0.085;
            $czesc_125 = max(0, $suma - 100000) * 0.125;
            $suma_podatku = round($czesc_85 + $czesc_125, 2); // ← tu zmiana z 0 na 2

            $summary[$displayName] = [
                'wynajmujacy' => $displayName,
                'rok' => $rok,
                'miesiac' => Carbon::createFromDate($rok, $miesiac, 1)->translatedFormat('F'),
                'suma' => $suma,
                'czesc_85' => round($czesc_85, 2),
                'czesc_125' => round($czesc_125, 2),
                'podatek' => $suma_podatku,
            ];
        }

        return $summary;
    }

    public static function getTaxBreakdownByLandlordAndApartment(int $rok, int $miesiac): array
    {
        $result = [];

        $all = self::getTaxSummaryByLandlord($rok, $miesiac);

        foreach ($all as $landlord => $summary) {
            $entries = Finance::with('apartment')
                ->whereRaw('LOWER(TRIM(wynajmujacy)) = ?', [trim(mb_strtolower($landlord))]) // ← dopasowanie poprawione
                ->where('typ', 'Przychód')
                ->whereYear('data', $rok)
                ->whereMonth('data', $miesiac)
                ->whereHas('expenseType', fn($q) => $q->where('taxable', true))
                ->get()
                ->filter(fn($entry) => $entry->apartment_id !== null)
                ->groupBy('apartment_id');

            foreach ($entries as $apartmentId => $incomes) {
                $sumaMieszkania = $incomes->sum('kwota');
                $udzial = $summary['suma'] > 0 ? $sumaMieszkania / $summary['suma'] : 0;

                $czesc_85 = min($summary['suma'], 100000) * $udzial * 0.085;
                $czesc_125 = max(0, $summary['suma'] - 100000) * $udzial * 0.125;
                $podatek = round($czesc_85 + $czesc_125, 2);

                $result[$landlord]['info'] = $summary;
                $result[$landlord]['mieszkania'][] = [
                    'apartment_id' => $apartmentId,
                    'adres' => optional($incomes->first()->apartment)->miasto . ', ' . optional($incomes->first()->apartment)->ulica,
                    'suma' => $sumaMieszkania,
                    'procent' => round($udzial * 100, 2),
                    'czesc_85' => round($czesc_85, 2),
                    'czesc_125' => round($czesc_125, 2),
                    'podatek' => $podatek,
                ];
            }
        }

        return $result;
    }
}
