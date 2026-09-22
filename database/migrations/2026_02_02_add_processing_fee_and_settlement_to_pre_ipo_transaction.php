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
        Schema::table('pre_ipo_transaction', function (Blueprint $table) {
            $table->decimal('processing_fee', 40, 2)->default(0)->after('investment_amount')->comment('2% processing fee on investment amount');
            $table->decimal('payable_amount', 40, 2)->default(0)->after('processing_fee')->comment('Investment amount + processing fee - coupon discount');
            $table->date('settlement_date')->nullable()->after('payable_amount')->comment('T+1 settlement date (excludes weekends and holidays)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pre_ipo_transaction', function (Blueprint $table) {
            $table->dropColumn(['processing_fee', 'payable_amount', 'settlement_date']);
        });
    }
};
