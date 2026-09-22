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
            $table->enum(
                'category',
                array_column(PreIpoCategoryEnum::cases(), 'value')  // Adds DRHP
            )
                ->default(PreIpoCategoryEnum::trending->value)
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company', function (Blueprint $table) {
            DB::table('company')
                ->where('category', 'DRHP')
                ->update(['category' => 'Trending']);  // Map to existing value

            // 2. Redefine enum WITHOUT DRHP - this removes it from column
            $table->enum('category', [
                'Trending',
                'Coming Soon',
                'Exclusive Deals',
                'Listed',
                'Liquid Stocks'
            ])
                ->default('Trending')
                ->change();
        });
    }
};
