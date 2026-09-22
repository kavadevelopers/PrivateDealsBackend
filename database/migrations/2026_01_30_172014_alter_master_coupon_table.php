<?php

use App\Enums\CouponTypeEnum;
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
            $table->enum('type', array_column(CouponTypeEnum::cases(), 'value'))->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_coupon', function (Blueprint $table) {
            $table->enum('type', ['flat_discount', 'percentage_discount', 'per_share_discount', 'cashback'])
                ->default('flat_discount')
                ->change();
        });
    }
};
