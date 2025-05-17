<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('mieszkania', function (Blueprint $table) {
            $table->id();
            $table->string('adres');
            $table->string('notatka')->nullable(); // Dodana kolumna notatka
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mieszkania');
    }
};
