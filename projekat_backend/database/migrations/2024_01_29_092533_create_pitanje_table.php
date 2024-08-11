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
        Schema::create('pitanjes', function (Blueprint $table) {
            $table->id();
            $table->string('tekst_pitanja');
            $table->string('kod_sobe')->nullable(); // Dodajemo kolonu kod_sobe
            $table->foreign('kod_sobe')->references('kod_sobe')->on('sobas'); // Dodavanje spoljnog ključa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pitanjes', function (Blueprint $table) {
            $table->dropForeign(['kod_sobe']);
            $table->dropColumn('kod_sobe');
        });
        Schema::dropIfExists('pitanjes');
    }
};
