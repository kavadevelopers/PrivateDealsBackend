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
        Schema::create('investor', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->unsignedBigInteger('partner_id')->nullable(); //business partner
            $table->unsignedBigInteger('parent_investor_id')->nullable(); //parent investor
            $table->unsignedBigInteger('family_relation_id')->nullable();
            $table->enum('investor_type', ['Individual', 'Hindu Undivided Family', 'Private Limited', 'Public Limited', 'Partnership', 'Limited Liability Partnership'])->nullable();
            $table->string('name');
            $table->string('mobile_country_code', 5)->default(91);
            $table->string('mobile_number', 20);
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('pincode', 10)->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->string('profile_photo')->nullable();
            $table->string('password')->nullable();
            $table->enum('profile_visibility', ['Public', 'Name Only', 'Private'])->default('Private');
            $table->integer('registration_step')->default('0')->comment('3 registration complete');
            $table->boolean('kyc_status')->default('0');
            $table->enum('aadhar_verified_type', ['Manual', 'e-KYC'])->nullable();
            $table->boolean('is_fake_investor')->default('0');
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
        Schema::dropIfExists('investor');
    }
};
