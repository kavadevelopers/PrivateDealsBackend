<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStartIdToStartupId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('startup_financial_details', function (Blueprint $table) {
            $table->renameColumn('start_id', 'startup_id');
        });

        Schema::table('startup_other_details', function (Blueprint $table) {
            $table->renameColumn('start_id', 'startup_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('startup_financial_details', function (Blueprint $table) {
            $table->renameColumn('startup_id', 'start_id');
        });

        Schema::table('startup_other_details', function (Blueprint $table) {
            $table->renameColumn('startup_id', 'start_id');
        });
    }
}
