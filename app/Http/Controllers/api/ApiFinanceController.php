<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExpenseType;
use App\Models\Mieszkanie;
use App\Services\TaxService;

class ApiFinanceController extends Controller
{
    public function getCategories(string $typ)
    {
        $typ = ucfirst(strtolower($typ));

        $dane = ExpenseType::whereRaw('LOWER(name) = ?', [strtolower($typ)])
            ->get(['id', 'category']);

        return response()->json(
            $dane->map(fn($item) => [
                'value' => $item->id,
                'label' => $item->category,
            ])->values()
        );
    }

    public function getTax(Request $request)
    {
        $apartmentId = $request->query('apartment_id');
        if (!$apartmentId) return response()->json(['amount' => null]);

        $apartment = Mieszkanie::with('residents')->find($apartmentId);
        $landlord = $apartment?->residents->last()?->wynajmujacy;
        if (!$landlord) return response()->json(['amount' => null]);

        $today = now();
        $lastMonth = $today->copy()->subMonth();
        $taxData = TaxService::getTaxBreakdownByLandlordAndApartment($today->year, $lastMonth->month);

        $kwota = collect($taxData[$landlord]['mieszkania'] ?? [])
            ->firstWhere('apartment_id', $apartmentId)['podatek'] ?? null;

        return response()->json(['amount' => $kwota]);
    }
}
