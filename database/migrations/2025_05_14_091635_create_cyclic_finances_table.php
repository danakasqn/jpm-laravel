<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cyclic_finances', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // np. "Urząd Skarbowy"
            $table->enum('type', ['income', 'expense']);
            $table->integer('due_day'); // np. 10 (dzień miesiąca)

            // Poprawny klucz obcy do tabeli "mieszkania"
            $table->foreignId('apartment_id')
                ->nullable()
                ->constrained('mieszkania')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cyclic_finances');
    }
};
