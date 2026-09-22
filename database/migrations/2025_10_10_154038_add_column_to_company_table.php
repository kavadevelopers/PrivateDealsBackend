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
            $table->string('current_split_ratio')->nullable()->after('last_year_share_price');
            $table->date('last_split_date')->nullable()->after('current_split_ratio');
            $table->boolean('has_active_split')->default(false)->after('last_split_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company', function (Blueprint $table) {
            $table->dropColumn(['current_split_ratio', 'last_split_date', 'has_active_split']);
        });
    }
};
