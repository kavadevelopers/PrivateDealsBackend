<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investor_coupon', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('investor_id');
            $table->unsignedBigInteger('coupon_id');
            $table->unsignedBigInteger('referral_id')->nullable();
            $table->enum('status', ['assigned', 'redeemed', 'expired', 'cancelled'])->default('assigned');
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('redeemed_at')->nullable();
            $table->unsignedBigInteger('redeemed_primary_transaction_id')->nullable();
            $table->unsignedBigInteger('redeemed_secondary_transaction_id')->nullable();
            $table->unsignedBigInteger('redeemed_pre_ipo_transaction_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investor_coupon');
    }
};
