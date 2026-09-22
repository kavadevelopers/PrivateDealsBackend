<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('primary_transaction', function (Blueprint $table) {
            $table->unsignedBigInteger('investor_coupon_id')->nullable()->after('portfolio_id');
            $table->string('coupon_code_snapshot', 100)->nullable()->after('investor_coupon_id');
            $table->decimal('coupon_discount_amount', 40, 2)->default(0)->after('coupon_code_snapshot');
        });
    }

    public function down(): void
    {
        Schema::table('primary_transaction', function (Blueprint $table) {
            $table->dropColumn(['investor_coupon_id', 'coupon_code_snapshot', 'coupon_discount_amount']);
        });
    }
};
