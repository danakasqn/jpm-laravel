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

            // Relacja do typów wydatków (np. "Przychód" / "Wydatek" + kategoria)
            $table->foreignId('expense_type_id')
                  ->constrained('expense_types')
                  ->cascadeOnDelete();

            // Typ operacji: Przychód lub Wydatek
            $table->enum('type', ['Przychód', 'Wydatek']);

            // Dzień miesiąca, np. 10
            $table->unsignedTinyInteger('due_day');

            // Powiązane mieszkanie
            $table->foreignId('apartment_id')
                  ->nullable()
                  ->constrained('mieszkania')
                  ->nullOnDelete();

            // Kwota może być pusta (np. dla podatku liczonego dynamicznie)
            $table->decimal('amount', 10, 2)->nullable();

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
