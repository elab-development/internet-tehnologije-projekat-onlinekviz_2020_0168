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
        Schema::create('rezultats', function (Blueprint $table) {
            $table->id();
            $table->string('naziv_sobe');
            $table->string('ime_igraca');
            $table->integer('trenutni_rezultat');
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rezultats');
    }
};
