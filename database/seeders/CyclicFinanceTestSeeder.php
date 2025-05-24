<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mieszkanie;
use App\Models\ExpenseType;
use App\Models\CyclicFinance;

class CyclicFinanceTestSeeder extends Seeder
{
    public function run(): void
    {
        // Mieszkanie testowe
        $mieszkanie = Mieszkanie::create([
            'adres' => 'Testowa 123',
            'miasto' => 'Testowo',
            'ulica' => 'Testowa',
            'wlasciciel' => 'Jan Kowalski',
        ]);

        // Kategoria testowa
        $kategoria = ExpenseType::create([
            'name' => 'Media',
            'category' => 'Prąd',
        ]);

        // Wpis cykliczny z dzisiejszym due_day
        CyclicFinance::create([
            'expense_type_id' => $kategoria->id,
            'type' => 'Wydatek',
            'due_day' => now()->day,
            'apartment_id' => $mieszkanie->id,
            'amount' => 150.00,
        ]);
    }
}
