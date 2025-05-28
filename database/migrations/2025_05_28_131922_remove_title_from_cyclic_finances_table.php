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
    Schema::create('cyclic_finances_temp', function (Blueprint $table) {
        $table->id();
        $table->foreignId('expense_type_id');
        $table->string('type');
        $table->integer('due_day');
        $table->foreignId('apartment_id')->nullable();
        $table->decimal('amount', 8, 2)->nullable();
        $table->timestamps();
    });

    DB::statement('INSERT INTO cyclic_finances_temp (id, expense_type_id, type, due_day, apartment_id, amount, created_at, updated_at)
                   SELECT id, expense_type_id, type, due_day, apartment_id, amount, created_at, updated_at
                   FROM cyclic_finances');

    Schema::drop('cyclic_finances');

    Schema::rename('cyclic_finances_temp', 'cyclic_finances');
}

public function down()
{
    Schema::table('cyclic_finances', function (Blueprint $table) {
        $table->string('title'); // Dodaj jeśli chcesz przywrócić
    });
}

};
