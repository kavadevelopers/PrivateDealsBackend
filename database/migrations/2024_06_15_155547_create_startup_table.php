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
        Schema::create('startup', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('url_slug')->nullable();
            $table->string('brand_name')->nullable();
            $table->unsignedBigInteger('sector_id')->nullable(); //master sector
            $table->unsignedBigInteger('city_id')->nullable(); //master city
            $table->unsignedBigInteger('state_id')->nullable(); //master state
            $table->unsignedBigInteger('country_id')->nullable(); //master country
            $table->string('company_name')->nullable();
            $table->string('mobile_country_code', 5)->default(91);
            $table->string('mobile_number', 20);
            $table->string('email')->nullable();
            $table->text('brief_information')->nullable();
            $table->text('address')->nullable();
            $table->string('pincode', 10)->nullable();
            $table->string('representative_name')->nullable();
            $table->string('representative_pan', 10)->nullable();
            $table->text('representative_address')->nullable();
            $table->string('password')->nullable();
            $table->integer('registration_step')->default('0')->comment('4 registration complete');
            $table->boolean('is_fake')->default('0');
            $table->boolean('is_verified_mobile')->default('0');
            $table->boolean('is_verified_email')->default('0');
            $table->boolean('ask_password_change')->default('0');
            $table->boolean('is_active')->default('0');
            $table->boolean('is_blocked')->default('0');
            $table->boolean('is_deleted')->default('0');
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
        Schema::dropIfExists('startup');
    }
};
