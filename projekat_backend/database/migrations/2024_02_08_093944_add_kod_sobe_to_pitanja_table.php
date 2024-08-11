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
        // Schema::table('pitanjes', function (Blueprint $table) {
        //     $table->unsignedBigInteger('id_sobe')->nullable();
        //     $table->foreign('kod_sobe')->references('kod_sobe')->on('sobas'); // Promenjeno sa 'sobe' na 'sobas'
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('pitanjes', function (Blueprint $table) {
        //     $table->dropForeign(['kod_sobe']);
        //     $table->dropColumn('kod_sobe');
        // });
    }
    
};
