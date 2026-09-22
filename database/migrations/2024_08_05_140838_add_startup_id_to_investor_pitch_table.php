<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStartupIdToInvestorPitchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investor_pitch', function (Blueprint $table) {
            $table->unsignedInteger('startup_id')->after('pitch_id'); // Adds the column after 'pitch_id'
            
            // Optional: add foreign key constraint if there's a related 'startups' table
            // $table->foreign('startup_id')->references('id')->on('startups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('investor_pitch', function (Blueprint $table) {
            $table->dropColumn('startup_id');
            
            // Optional: drop foreign key constraint if added
            // $table->dropForeign(['startup_id']);
        });
    }
}
