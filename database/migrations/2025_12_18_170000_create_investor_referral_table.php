<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investor_referral', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('referrer_investor_id');
            $table->string('referral_code', 50);
            $table->unsignedBigInteger('referred_investor_id')->nullable();
            $table->enum('status', ['pending', 'completed', 'cancelled', 'rejected'])->default('pending');
            $table->unsignedBigInteger('referrer_coupon_id')->nullable();
            $table->unsignedBigInteger('referred_coupon_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investor_referral');
    }
};
