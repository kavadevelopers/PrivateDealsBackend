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
        Schema::table('primary_transaction', function (Blueprint $table) {
            $table->unsignedBigInteger('mgt14_id')->nullable()->change();
            $table->unsignedBigInteger('pas3_id')->nullable()->change();
            $table->unsignedBigInteger('portfolio_id')->nullable()->change();
            $table->string('offerletterno')->nullable()->change();
            $table->decimal('shares', 40, 2)->default(0)->nullable()->change();
            $table->decimal('share_price', 40, 2)->default(0)->nullable()->change();
            $table->decimal('investment_amount', 40, 2)->default(0)->nullable()->change();
            $table->boolean('payment_status')->default(0)->nullable()->change();
            $table->boolean('is_share_transfered')->default(0)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('primary_transaction', function (Blueprint $table) {
            $table->unsignedBigInteger('mgt14_id')->nullable(false)->change();
            $table->unsignedBigInteger('pas3_id')->nullable(false)->change();
            $table->unsignedBigInteger('portfolio_id')->nullable(false)->change();
            $table->string('offerletterno')->nullable(false)->change();
            $table->decimal('shares', 40, 2)->default(0)->nullable(false)->change();
            $table->decimal('share_price', 40, 2)->default(0)->nullable(false)->change();
            $table->decimal('investment_amount', 40, 2)->default(0)->nullable(false)->change();
            $table->boolean('payment_status')->default(0)->nullable(false)->change();
            $table->boolean('is_share_transfered')->default(0)->nullable(false)->change();
        });
    }
};
