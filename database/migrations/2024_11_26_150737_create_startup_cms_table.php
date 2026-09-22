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
        Schema::create('startup_cms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('startup_id');
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->string('long_banner')->nullable();
            $table->string('product_video')->nullable();
            $table->string('pitch_video')->nullable();
            $table->string('pitch_deck')->nullable();
            $table->string('financial_projection')->nullable();
            $table->string('dd_report')->nullable();
            $table->string('dpiit_report')->nullable();
            $table->string('shuruup_research_report')->nullable();
            $table->string('valuation_report')->nullable();
            $table->string('one_liner')->nullable();
            $table->text('highlights')->nullable();
            $table->text('website')->nullable();
            $table->text('idea')->nullable();
            $table->text('key_information')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('startup_cms');
    }
};
