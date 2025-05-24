<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Finance;
use App\Models\CyclicFinance;
use App\Services\FinanceReminderService;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Carbon::setLocale('pl');

        View::composer('*', function ($view) {
            if (Auth::check()) {
                // Używamy serwisu do pobrania pełnej kolekcji zaległych operacji
                $pendingOperations = FinanceReminderService::getPendingOperations();
                $pendingCount = $pendingOperations->count();

                // Opcjonalnie: przypisz też pendingOperations do widoków (np. dla dev/debug)
                $view->with('pendingOperations', $pendingOperations);
                $view->with('pendingCount', $pendingCount);
            }
        });
    }
}