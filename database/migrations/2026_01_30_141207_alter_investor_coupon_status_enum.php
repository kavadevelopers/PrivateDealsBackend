<?php

use App\Enums\InvestorCouponStatusEnum;
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
        Schema::table('investor_coupon', function (Blueprint $table) {
            $table->enum('status', array_column(InvestorCouponStatusEnum::cases(), 'value'))->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investor_coupon', function (Blueprint $table) {
            $table->enum('status', ['assigned', 'redeemed', 'expired', 'cancelled'])
                ->default('assigned')
                ->change();
        });
    }
};
