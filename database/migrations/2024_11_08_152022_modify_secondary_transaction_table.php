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
            $table->unsignedBigInteger('portfolio_id')->nullable()->change();
            $table->unsignedBigInteger('sell_request_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('secondary_transaction', function (Blueprint $table) {
            $table->unsignedBigInteger('portfolio_id')->nullable(false)->change();
            $table->unsignedBigInteger('sell_request_id')->nullable(false)->change();
        });
    }
};
