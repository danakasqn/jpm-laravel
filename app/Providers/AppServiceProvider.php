<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Finance;
use App\Models\CyclicFinance;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $today = now();
                $start = $today->copy()->startOfMonth()->toDateString();
                $end = $today->copy()->endOfMonth()->toDateString();

                $missingCyclicCount = CyclicFinance::all()->filter(function ($cyclic) use ($start, $end) {
                    return !Finance::where('kategoria', $cyclic->title)
                        ->where('typ', $cyclic->type === 'income' ? 'Przychód' : 'Wydatek')
                        ->where('apartment_id', $cyclic->apartment_id)
                        ->whereBetween('data', [$start, $end])
                        ->exists();
                })->count();

                $view->with('pendingCount', $missingCyclicCount);
            }
        });
    }
}
