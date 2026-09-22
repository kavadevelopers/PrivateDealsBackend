<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investor_consultancy_slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('investor_id');
            $table->date('booking_date');
            $table->time('booking_time');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->text('description')->nullable();
            $table->string('mobile_number', 20);
            $table->string('mobile_country_code', 5)->default('91');
            $table->string('google_meet_link')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();

            $table->index('investor_id');
            $table->index('booking_date');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investor_consultancy_slots');
    }
};
