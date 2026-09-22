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
        Schema::create('partner', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->enum('type', ['Wealth Manager', 'Distributor', 'Retailer'])->nullable();
            $table->enum('parent_type', ['Wealth Manager', 'Distributor', 'Retailer'])->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('name');
            $table->string('mobile_country_code', 5)->default(91);
            $table->string('mobile_number', 20);
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->decimal('commission')->nullable();
            $table->string('password')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('pincode', 10)->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->boolean('is_verified_mobile')->default('0');
            $table->boolean('is_verified_email')->default('0');
            $table->string('profile_photo')->nullable();
            $table->boolean('ask_password_change')->default('0');
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
        Schema::dropIfExists('partner');
    }
};
