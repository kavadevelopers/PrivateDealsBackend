<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFloorAndCapToTableName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('startup_other_details', function (Blueprint $table) {
            // Add columns after `equity_offered`
            $table->decimal('floor', 10, 2)->nullable()->after('equity_offered');
            $table->decimal('cap', 10, 2)->nullable()->after('floor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('startup_other_details', function (Blueprint $table) {
            $table->dropColumn(['floor', 'cap']);
        });
    }
}
