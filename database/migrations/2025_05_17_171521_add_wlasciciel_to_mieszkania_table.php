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
    Schema::table('mieszkania', function (Blueprint $table) {
        $table->string('wlasciciel')->nullable()->after('email');
    });
}

public function down()
{
    Schema::table('mieszkania', function (Blueprint $table) {
        $table->dropColumn('wlasciciel');
    });
}

};
