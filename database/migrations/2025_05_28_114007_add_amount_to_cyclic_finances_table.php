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
        if (!Schema::hasColumn('cyclic_finances', 'amount')) {
    $table->decimal('amount', 10, 2)->nullable();
}
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      //  Schema::table('cyclic_finances', function (Blueprint $table) {
       //     $table->dropColumn('amount');
     //   });
    }
};
