<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finances', function (Blueprint $table) {
            $table->id();

            // Powiązania
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('apartment_id')->nullable();
            $table->unsignedBigInteger('expense_type_id');

            // Dane finansowe
            $table->date('data');
            $table->string('typ'); // Przychód lub Wydatek
            $table->decimal('kwota', 10, 2);
            $table->string('kategoria')->nullable(); // Można usunąć, jeśli jest zbędna
            $table->text('notatka')->nullable();

            $table->timestamps();

            // Relacje (klucze obce)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('apartment_id')->references('id')->on('mieszkania')->onDelete('set null');
            $table->foreign('expense_type_id')->references('id')->on('expense_types')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finances');
    }
};
