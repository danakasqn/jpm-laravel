<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tworzy testowego użytkownika
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Uruchomienie testowego seeda z mieszkańcem
        $this->call([
            ResidentTestSeeder::class,
        ]);
    }
}
