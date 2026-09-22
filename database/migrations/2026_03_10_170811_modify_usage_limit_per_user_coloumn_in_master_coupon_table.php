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
        Schema::table('master_coupon', function (Blueprint $table) {
            $table->integer('usage_limit_per_user')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_coupon', function (Blueprint $table) {
            $table->integer('usage_limit_per_user')->default(1)->change();
        });
    }
};
