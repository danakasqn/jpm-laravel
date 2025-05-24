<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\MieszkanieController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\CyclicFinanceController;
use App\Http\Controllers\ExpenseTypeController;
use App\Models\ExpenseType;
use App\Models\Mieszkanie;
use App\Services\TaxService;

// 🌐 Strona powitalna
Route::get('/', fn () => view('welcome'));

// 📊 Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// 🔐 Sekcja dostępna po zalogowaniu
Route::middleware(['auth'])->group(function () {

    // 💰 Finanse
    Route::prefix('finanse')->name('finanse.')->group(function () {
        Route::get('/', [FinanceController::class, 'index'])->name('index');
        Route::get('/formularz', [FinanceController::class, 'formularz'])->name('formularz');
        Route::get('/operacje', [FinanceController::class, 'operacjeDoWykonania'])->name('operacje');
        Route::post('/zapisz', [FinanceController::class, 'zapisz'])->name('zapisz');
        Route::get('/edytuj/{id}', [FinanceController::class, 'edytuj'])->name('edytuj');
        Route::put('/aktualizuj/{id}', [FinanceController::class, 'aktualizuj'])->name('aktualizuj');
        Route::patch('/zamknij/{id}', [FinanceController::class, 'oznaczJakoWykonane'])->name('zamknij');
        Route::delete('/{id}', [FinanceController::class, 'usun'])->name('usun');
    });

    // 🔁 Finanse cykliczne
    Route::resource('cyclic-finances', CyclicFinanceController::class)->except(['show']);
    Route::get('/cyclic-finances/urzad-skarbowy', [CyclicFinanceController::class, 'urzadSkarbowy'])->name('cyclic-finances.urzad-skarbowy');

    // 🔄 API – Kategorie przychodów/wydatków
    Route::get('/api/finanse/kategorie/{typ}', function ($typ) {
    try {
        $typ = ucfirst(strtolower($typ));
        $dane = ExpenseType::whereRaw('LOWER(name) = ?', [strtolower($typ)])
            ->get(['id', 'category']);

        return response()->json(
            $dane->map(fn($item) => [
                'value' => $item->id,
                'label' => $item->category,
            ])->values()
        );
    } catch (\Throwable $e) {
        Log::error('❌ Błąd w /api/finanse/kategorie:', ['error' => $e->getMessage()]);
        return response()->json([], 500);
    }
    })->name('api.kategorie');

    // 📊 API – Dynamiczne przeliczenie podatku dla mieszkania
    Route::get('/api/podatek', function (Request $request) {
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
    })->name('api.podatek');

    // 🏢 Lokale
    Route::prefix('lokale')->name('mieszkania.')->group(function () {
        Route::get('/', [MieszkanieController::class, 'index'])->name('index');
        Route::post('/zapisz', [MieszkanieController::class, 'zapisz'])->name('zapisz');
        Route::get('/{mieszkanie}/edytuj', [MieszkanieController::class, 'edytuj'])->name('edytuj');
        Route::put('/{mieszkanie}', [MieszkanieController::class, 'aktualizuj'])->name('aktualizuj');
        Route::delete('/{mieszkanie}', [MieszkanieController::class, 'usun'])->name('usun');
    });

    // 👥 Najemcy
    Route::resource('residents', ResidentController::class);

    // 👤 Profil użytkownika
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ⚙️ Ustawienia – Typy operacji
    Route::prefix('ustawienia')->name('settings.')->group(function () {
        Route::resource('typy-wydatkow', ExpenseTypeController::class)
            ->parameters(['typy-wydatkow' => 'typy_wydatkow'])
            ->names('expense-types');
    });
});

// 🔐 Autoryzacja (np. Breeze lub Jetstream)
require __DIR__.'/auth.php';
