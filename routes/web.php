<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\MieszkanieController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CyclicFinanceController;
use App\Http\Controllers\MapController;

Route::get('/', function () {
    return view('welcome');
});

// ✅ Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// 🔐 Trasy dostępne tylko po zalogowaniu
Route::middleware(['auth'])->group(function () {

    // ✅ Finanse – główna + formularz + operacje
    Route::get('/finanse', [FinanceController::class, 'index'])->name('finanse.index');
    Route::get('/finanse/formularz', [FinanceController::class, 'formularz'])->name('finanse.formularz');
    Route::get('/finanse/operacje', [FinanceController::class, 'operacjeDoWykonania'])->name('finanse.operacje');
    Route::patch('/finanse/zamknij/{id}', [FinanceController::class, 'oznaczJakoWykonane'])->name('finanse.zamknij');

    // ✅ Finanse – CRUD
    Route::post('/finanse/zapisz', [FinanceController::class, 'zapisz'])->name('finanse.zapisz');
    Route::get('/finanse/edytuj/{id}', [FinanceController::class, 'edytuj'])->name('finanse.edytuj');
    Route::put('/finanse/aktualizuj/{id}', [FinanceController::class, 'aktualizuj'])->name('finanse.aktualizuj');
    Route::delete('/finanse/{id}', [FinanceController::class, 'usun'])->name('finanse.usun');

    // ✅ Finanse cykliczne
    Route::resource('cyclic-finances', CyclicFinanceController::class);

    // ✅ Mieszkania
    Route::get('/mieszkania', [MieszkanieController::class, 'index'])->name('mieszkania.index');
    Route::post('/mieszkania/zapisz', [MieszkanieController::class, 'zapisz'])->name('mieszkania.zapisz');
    Route::get('/mieszkania/edytuj/{id}', [MieszkanieController::class, 'edytuj'])->name('mieszkania.edytuj');
    Route::put('/mieszkania/aktualizuj/{id}', [MieszkanieController::class, 'aktualizuj'])->name('mieszkania.aktualizuj');
    Route::delete('/mieszkania/{id}', [MieszkanieController::class, 'usun'])->name('mieszkania.usun');

    // ✅ Mieszkańcy
    Route::resource('/residents', ResidentController::class);

    // ✅ Profil użytkownika
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ✅ Autoryzacja i rejestracja
require __DIR__.'/auth.php';
