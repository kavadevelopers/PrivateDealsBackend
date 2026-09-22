<?php

use App\Enums\CompanyDealTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('company_deals', function (Blueprint $table) {
            $table->enum('deal_type', array_column(CompanyDealTypeEnum::cases(), 'value'))
                ->default(CompanyDealTypeEnum::sell->value)
                ->after('status');
            $table->index('deal_type');
        });
    }

    public function down(): void
    {
        Schema::table('company_deals', function (Blueprint $table) {
            $table->dropIndex(['deal_type']);
            $table->dropColumn('deal_type');
        });
    }
};
