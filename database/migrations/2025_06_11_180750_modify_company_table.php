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
        Schema::table('company', function (Blueprint $table) {
            $table->decimal('share_price', 40, 2)->default(0.00)->after('about');
            $table->decimal('distributer_price', 40, 2)->default(0.00)->after('share_price');
            $table->decimal('base_price', 40, 2)->default(0.00)->after('distributer_price');
            $table->boolean('price_updated_today')->default(0)->after('base_price');
            $table->decimal('last_year_share_price', 40, 2)->default(0.00)->after('price_updated_today');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company', function (Blueprint $table) {
            $table->dropColumn('share_price');
            $table->dropColumn('distributer_price');
            $table->dropColumn('base_price');
            $table->dropColumn('price_updated_today');
            $table->dropColumn('last_year_share_price');
        });
    }
};
