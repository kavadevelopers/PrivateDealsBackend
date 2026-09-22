<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_coupon', function (Blueprint $table) {
            $table->id();
            $table->uuid()->nullable();
            $table->string('code', 100)->unique();
            $table->enum('type', ['flat_discount', 'percentage_discount', 'per_share_discount', 'cashback']);
            $table->text('description')->nullable();
            $table->decimal('discount_value', 15, 4);
            $table->decimal('max_discount_amount', 15, 2)->nullable();
            $table->enum('applies_on', ['primary', 'secondary', 'pre_ipo', 'all'])->default('all');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('startup_id')->nullable();
            $table->decimal('min_investment_amount', 15, 2)->nullable();
            $table->smallInteger('usage_limit_per_user')->default(1);
            $table->integer('usage_limit_global')->nullable();
            $table->timestamp('valid_from')->nullable();
            $table->timestamp('valid_to')->nullable();
            $table->boolean('is_active')->default(true);
            $table->enum('created_via', ['referral', 'manual', 'campaign'])->default('manual');
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_coupon');
    }
};
