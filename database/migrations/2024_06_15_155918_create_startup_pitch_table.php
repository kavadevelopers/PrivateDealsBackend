<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('startup_pitch', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('startup_id')->nullable();
            $table->unsignedBigInteger('startup_round_id')->nullable();
            $table->string('title');
            $table->text('description');
            $table->date('date');
            $table->time('time');
            $table->dateTime('datetime');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('startup_pitch');
    }
};
