<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStartupPitchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('startup_pitch', function (Blueprint $table) {
            // Check if 'datetime' column exists before renaming
            if (Schema::hasColumn('startup_pitch', 'datetime')) {
                $table->renameColumn('datetime', 'scheduled_date');
            }
            
            // Drop 'date' and 'time' columns if they exist
            if (Schema::hasColumn('startup_pitch', 'date')) {
                $table->dropColumn('date');
            }
            if (Schema::hasColumn('startup_pitch', 'time')) {
                $table->dropColumn('time');
            }
            
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('startup_pitch', function (Blueprint $table) {
            // Add 'date' and 'time' columns back
            $table->date('date')->after('title');
            $table->time('time')->after('date');
            
            // Rename 'scheduled_date' column back to 'datetime'
            if (Schema::hasColumn('startup_pitch', 'scheduled_date')) {
                $table->renameColumn('scheduled_date', 'datetime');
            }
            
           
        });
    }
}
