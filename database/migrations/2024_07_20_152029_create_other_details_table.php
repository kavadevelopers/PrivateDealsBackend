<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('startup_other_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('start_id');
            $table->unsignedBigInteger('round_id');
            $table->unsignedInteger('number_of_founders')->nullable();
            $table->string('name_of_founder')->nullable();
            $table->unsignedInteger('age')->nullable();
            $table->string('education_qualification')->nullable();
            $table->string('work_exp')->nullable();
            $table->text('startup_failures_successful_exits')->nullable();
            $table->string('pitchdeck')->nullable();
            $table->string('financial_model')->nullable();
            $table->string('founder_email_id')->nullable();
            $table->string('founder_contact_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('startup_other_details');
    }
}
