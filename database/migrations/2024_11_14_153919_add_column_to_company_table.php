<?php

use App\Enums\MinimumInvestmentTypeEnum;
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
        Schema::table('company', function (Blueprint $table) {
            $table->enum('min_investment_type', array_column(MinimumInvestmentTypeEnum::cases(), 'value'))->nullable()->after('company_name');
            $table->decimal('min_investment_amount', 40, 2)->default(0)->after('min_investment_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company', function (Blueprint $table) {
            $table->dropColumn('min_investment_type');
            $table->dropColumn('min_investment_amount');
        });
    }
};
