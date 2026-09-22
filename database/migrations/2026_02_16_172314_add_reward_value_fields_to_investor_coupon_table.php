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
            $table->decimal('reward_value', 10, 2)->nullable()->after('coupon_id');
            $table->string('display_code', 20)->nullable()->after('referral_id')
                ->comment('Unique code shown to investor — used for referral coupons only');
            $table->enum('status', array_column(InvestorCouponStatusEnum::cases(), 'value'))->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investor_coupon', function (Blueprint $table) {
            $table->dropColumn('reward_value');
            $table->dropColumn('display_code');
        });
    }
};
