<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavouriteStartupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investor_favourite_startup', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('startup_id');
            $table->unsignedBigInteger('investor_id');
            $table->timestamps();

            // Optionally, you can add foreign key constraints if the related tables exist
            // $table->foreign('startup_id')->references('id')->on('startups')->onDelete('cascade');
            // $table->foreign('investor_id')->references('id')->on('investors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('investor_favourite_startup');
    }
}

