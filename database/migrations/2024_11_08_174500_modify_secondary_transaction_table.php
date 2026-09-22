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
        Schema::table('secondary_transaction', function (Blueprint $table) {
            $table->unsignedBigInteger('c_portfolio_id')->nullable()->after('portfolio_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('secondary_transaction', function (Blueprint $table) {
            $table->dropColumn('c_portfolio_id');
        });
    }
};
