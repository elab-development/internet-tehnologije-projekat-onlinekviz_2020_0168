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
        Schema::create('odgovors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pitanje_id')->constrained();
            $table->string('tekst_odgovora');
            $table->boolean('tacan_odgovor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('odgovors');
    }
};
