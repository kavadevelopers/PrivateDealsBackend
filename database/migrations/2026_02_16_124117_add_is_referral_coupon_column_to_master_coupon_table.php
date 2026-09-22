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
        Schema::table('master_coupon', function (Blueprint $table) {
            $table->boolean('is_referral_coupon')->default(false)->after('created_via');
            $table->boolean('assign_to_referrer')->default(false)->after('is_referral_coupon');
            $table->boolean('assign_to_referred')->default(false)->after('assign_to_referrer');
            $table->decimal('referrer_reward_value', 10, 2)
                ->nullable()
                ->after('assign_to_referred');

            $table->decimal('referred_reward_value', 10, 2)
                ->nullable()
                ->after('referrer_reward_value');
            $table->tinyInteger('is_private')->default(1)->after('is_active');
            $table->boolean('is_deleted')->default(false)->after('is_private');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_coupon', function (Blueprint $table) {
            $table->dropColumn('is_referral_coupon');
            $table->dropColumn('assign_to_referrer');
            $table->dropColumn('assign_to_referred');
            $table->dropColumn('referrer_reward_value');
            $table->dropColumn('referred_reward_value');
            $table->dropColumn('is_private');
            $table->dropColumn('is_deleted');
        });
    }
};
