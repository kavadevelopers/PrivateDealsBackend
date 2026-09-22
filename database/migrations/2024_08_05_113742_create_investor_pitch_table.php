<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestorPitchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investor_pitch', function (Blueprint $table) {
            $table->increments('id'); // Auto-incrementing primary key
            $table->unsignedInteger('investor_id'); // Foreign key for investors
            $table->unsignedInteger('pitch_id'); // Foreign key for pitches
            $table->string('status'); // Status column
            $table->timestamps(); // Created_at and updated_at timestamps

            // Add foreign key constraints if needed
            // $table->foreign('investor_id')->references('id')->on('investors')->onDelete('cascade');
            // $table->foreign('pitch_id')->references('id')->on('pitches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('investor_pitch');
    }
}
