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
    Schema::table('residents', function (Blueprint $table) {
        $table->text('komentarz')->nullable()->after('do_kiedy');
    });
}

public function down()
{
    Schema::table('residents', function (Blueprint $table) {
        $table->dropColumn('komentarz');
    });
}
};
