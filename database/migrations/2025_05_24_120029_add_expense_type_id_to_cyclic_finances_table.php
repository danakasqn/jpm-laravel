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
    Schema::table('cyclic_finances', function (Blueprint $table) {
        $table->unsignedBigInteger('expense_type_id')->nullable()->after('apartment_id');

        $table->foreign('expense_type_id')
              ->references('id')
              ->on('expense_types')
              ->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('cyclic_finances', function (Blueprint $table) {
        $table->dropForeign(['expense_type_id']);
        $table->dropColumn('expense_type_id');
    });
}

};
