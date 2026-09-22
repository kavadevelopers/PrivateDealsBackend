<?php

use App\Enums\PrimaryTransactionPaymentMode;
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
        Schema::table('primary_transaction_payment', function (Blueprint $table) {
            $table->enum('type', array_column(PrimaryTransactionPaymentMode::cases(), 'value'))->after('document_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('primary_transaction_payment', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
