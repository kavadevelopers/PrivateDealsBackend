<?php

use App\Enums\PreIpoCategoryEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('company', function (Blueprint $table) {
            $table->decimal('final_min_investment_amount', 40, 2)
                ->default(35000.00)
                ->after('min_investment_amount');
        });

        // Exclusive Deals => 250000
        DB::table('company')
            ->where('category', PreIpoCategoryEnum::exclusive_deals->value)
            ->update([
                'final_min_investment_amount' => 250000
            ]);

        // Liquid Stocks => 15000
        DB::table('company')
            ->where('category', PreIpoCategoryEnum::liquid_stocks->value)
            ->update([
                'final_min_investment_amount' => 15000
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company', function (Blueprint $table) {
            $table->dropColumn('final_min_investment_amount');
        });
    }
};
