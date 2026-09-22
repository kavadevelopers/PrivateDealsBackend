<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHostUrlAndUserUrlToStartupPitchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('startup_pitch', function (Blueprint $table) {
            // Add 'host_url' and 'user_url' columns
            $table->string('host_url')->nullable()->after('scheduled_date');
            $table->string('user_url')->nullable()->after('host_url');
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
            // Drop 'host_url' and 'user_url' columns
            $table->dropColumn(['host_url', 'user_url']);
        });
    }
}
