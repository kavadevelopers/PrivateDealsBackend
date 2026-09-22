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
            $table->decimal('fees', 40, 2)->default(0)->after('investment_amount');
            $table->decimal('gst', 40, 2)->default(0)->after('fees');
            $table->decimal('amount_payable', 40, 2)->default(0)->after('gst');
            $table->decimal('shares', 40, 3)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('primary_transaction', function (Blueprint $table) {
            $table->dropColumn('fees');
            $table->dropColumn('gst');
            $table->dropColumn('amount_payable');
            $table->decimal('shares', 40, 2)->default(0)->change();
        });
    }
};
