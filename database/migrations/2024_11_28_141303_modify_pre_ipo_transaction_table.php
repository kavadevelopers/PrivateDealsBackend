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
        Schema::table('pre_ipo_transaction', function (Blueprint $table) {
            $table->decimal('shuru_price', 40, 2)->after('distributer_price')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pre_ipo_transaction', function (Blueprint $table) {
            $table->dropColumn('shuru_price');
        });
    }
};
