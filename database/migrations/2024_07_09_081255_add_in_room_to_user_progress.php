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
        Schema::table('user_progress', function (Blueprint $table) {
            $table->boolean('in_room')->after('question_number')->default(false);
        });
    }

    public function down()
    {
        Schema::table('user_progress', function (Blueprint $table) {
            $table->dropColumn('in_room');
        });
    }
};
