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
        Schema::table('startup_round', function (Blueprint $table) {
            $table->decimal('floor', 40, 2)->default(0)->after('instrument');
            $table->decimal('cap', 40, 2)->default(0)->after('floor');
            $table->decimal('equity_offered', 3, 2)->default(0)->after('cap');
            $table->decimal('minimum_investment', 40, 2)->default(0)->after('equity_offered');
            $table->decimal('minimum_investment_aif', 40, 2)->default(0)->after('minimum_investment');
            $table->decimal('total_fund_requirement', 40, 2)->default(0)->after('minimum_investment_aif');
            $table->decimal('fund_requirement', 40, 2)->default(0)->after('total_fund_requirement');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('startup_round', function (Blueprint $table) {
            $table->dropColumn([
                'floor',
                'cap',
                'equity_offered',
                'minimum_investment',
                'minimum_investment_aif',
                'total_fund_requirement',
                'fund_requirement'
            ]);
        });
    }
};
