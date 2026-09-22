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
            $table->boolean('is_cancelled_by_investor')->default(false)->after('notes')->comment('Indicates if the transaction was cancelled by the investor');
            $table->text('cancellation_reason')->nullable()->after('is_cancelled_by_investor')->comment('Reason for cancellation by the investor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pre_ipo_transaction', function (Blueprint $table) {
            $table->dropColumn(['is_cancelled_by_investor', 'cancellation_reason']);
        });
    }
};
