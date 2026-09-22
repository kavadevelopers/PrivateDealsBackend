<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncreaseLengthOfImageFieldsInInvestorKycTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investor_kyc', function (Blueprint $table) {
            $table->string('aadhaar_front_image', 225)->nullable()->change();
            $table->string('aadhaar_back_image', 225)->nullable()->change();
            $table->string('pan_image', 225)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('investor_kyc', function (Blueprint $table) {
            $table->string('aadhaar_front_image', 30)->nullable()->change();
            $table->string('aadhaar_back_image', 30)->nullable()->change();
            $table->string('pan_image', 30)->nullable()->change();
        });
    }
}
