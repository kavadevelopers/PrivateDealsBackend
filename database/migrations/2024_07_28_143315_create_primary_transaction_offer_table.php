<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrimaryTransactionOfferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('primary_transaction_offer', function (Blueprint $table) {
            $table->id(); // This will create an 'id' column as the primary key
            $table->unsignedBigInteger('startup_id'); // Foreign key for startup
            $table->unsignedBigInteger('round_id'); // Foreign key for round
            $table->string('offerletter'); // Assuming it's a string, adjust if needed
            $table->integer('status'); // Status column
            $table->timestamps(); // Created at and updated at columns

            // Add foreign key constraints if needed
            // $table->foreign('startup_id')->references('id')->on('startups')->onDelete('cascade');
            // $table->foreign('round_id')->references('id')->on('rounds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('primary_transaction_offer');
    }
}
