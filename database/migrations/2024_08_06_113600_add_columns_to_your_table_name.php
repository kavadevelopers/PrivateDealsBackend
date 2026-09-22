<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToYourTableName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('startup_other_details', function (Blueprint $table) {
            $table->string('ssa_id')->nullable()->after('founder_contact_number');
            $table->text('ssa_sign_coordinates')->nullable()->after('ssa_id');
            $table->string('offer_id')->nullable()->after('ssa_sign_coordinates');
            $table->text('offer_sign_coordinates')->nullable()->after('offer_id');
            $table->unsignedInteger('equity_offered')->nullable()->after('offer_sign_coordinates');
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
            $table->dropColumn(['ssa_id', 'ssa_sign_coordinates', 'offer_id', 'offer_sign_coordinates','equity_offered']);
        });
    }
}
