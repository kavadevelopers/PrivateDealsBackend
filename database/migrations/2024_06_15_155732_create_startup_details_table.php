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
        Schema::create('startup_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('startup_id');
            $table->text('short_description')->nullable();
            $table->text('info_description')->nullable();
            $table->text('key_information')->nullable();
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->string('long_banner')->nullable();
            $table->string('product_video')->nullable();
            $table->string('dpiit_startup_certificate')->nullable();
            $table->text('website_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('startup_details');
    }
};
