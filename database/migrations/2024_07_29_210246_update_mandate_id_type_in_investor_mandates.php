<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMandateIdTypeInInvestorMandates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investor_mandates', function (Blueprint $table) {
            // Change the column type
            $table->string('mandate_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('investor_mandates', function (Blueprint $table) {
            // Revert the column type change
            $table->bigInteger('mandate_id')->unsigned()->change();
        });
    }
}
