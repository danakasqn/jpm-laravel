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
        $table->string('miasto')->nullable();
        $table->string('ulica')->nullable();
        $table->string('metraz')->nullable();
        $table->string('wspolnota')->nullable();
        $table->string('telefon')->nullable();
        $table->string('email')->nullable();
    });
}

public function down()
{
    Schema::table('mieszkania', function (Blueprint $table) {
        $table->dropColumn(['miasto', 'ulica', 'metraz', 'wspolnota', 'telefon', 'email']);
    });

    }
};
