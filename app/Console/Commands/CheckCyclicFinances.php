<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CyclicFinance;
use App\Models\Finance;
use App\Models\DashboardNotification;
use Carbon\Carbon;

class CheckCyclicFinances extends Command
{
    protected $signature = 'cyclic:check';
    protected $description = 'Sprawdza brakujące cykliczne wpisy finansowe i tworzy powiadomienia';

    public function handle()
    {
        $today = now();
        $currentMonth = $today->format('Y-m');

        CyclicFinance::all()->each(function ($cyclic) use ($currentMonth, $today) {
            $dueDate = Carbon::parse("{$currentMonth}-{$cyclic->due_day}");

            // Pomijamy jeśli termin jeszcze nie minął
            if ($today->lt($dueDate)) {
                return;
            }

            $exists = Finance::where('title', $cyclic->title)
                ->whereMonth('date', $dueDate->month)
                ->whereYear('date', $dueDate->year)
                ->when($cyclic->apartment_id, fn ($q) => $q->where('apartment_id', $cyclic->apartment_id))
                ->exists();

            if (! $exists) {
                DashboardNotification::create([
                    'message' => "Brak wpisu dla: {$cyclic->title} do dnia {$cyclic->due_day} miesiąca.",
                    'type' => 'warning',
                ]);
            }
        });

        $this->info('Sprawdzenie cyklicznych finansów zakończone.');
    }
}
