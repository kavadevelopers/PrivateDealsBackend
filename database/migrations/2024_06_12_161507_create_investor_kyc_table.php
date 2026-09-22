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
        Schema::create('investor_kyc', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('investor_id')->nullable();
            $table->string('aadhar_no')->nullable();
            $table->string('pan_no')->nullable();
            $table->string('name_as_aadhar')->nullable();
            $table->string('name_as_pan')->nullable();
            $table->date('dob_as_aadhar')->nullable();
            $table->text('address_as_aadhar')->nullable();
            $table->string('aadhaar_front_image', 30)->nullable();
            $table->string('aadhaar_back_image', 30)->nullable();
            $table->string('pan_image', 30)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investor_kyc');
    }
};
