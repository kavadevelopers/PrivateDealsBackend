<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoundIdToStartupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('startup', function (Blueprint $table) {
            $table->unsignedBigInteger('round_id')->nullable()->after('uuid');

            // If you have a rounds table and want to create a foreign key constraint
            // $table->foreign('round_id')->references('id')->on('rounds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('startup', function (Blueprint $table) {
            // If you created a foreign key constraint, drop it first
            // $table->dropForeign(['round_id']);
            $table->dropColumn('round_id');
        });
    }
}
