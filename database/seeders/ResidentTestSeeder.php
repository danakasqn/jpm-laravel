<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mieszkanie;
use App\Models\Resident;
use Carbon\Carbon;

class ResidentTestSeeder extends Seeder
{
    public function run(): void
    {
        // Stwórz jedno mieszkanie
        $mieszkanie = Mieszkanie::create([
            'miasto' => 'Strzegowo',
            'ulica' => 'Niepodległości 78',
            'metraz' => 60.5,
            'wspolnota' => 'Wspólnota A',
            'telefon' => '123456789',
            'email' => 'kontakt@wspolnota.pl',
        ]);

        // Dodaj mieszkańca z kończącą się umową
        Resident::create([
            'imie_nazwisko' => 'Jan Kowalski',
            'apartment_id' => $mieszkanie->id,
            'od_kiedy' => Carbon::now()->subMonth(),
            'do_kiedy' => Carbon::now()->addDays(7),
            'email' => 'jan@example.com',
            'phone' => '987654321',
        ]);
    }
}
