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
        Schema::rename('investor_demat_account', 'investor_kyc_demat');

        Schema::table('investor_kyc_demat', function (Blueprint $table) {
            $table->string('document_id')->nullable()->after('demat_account');
            $table->boolean('manage_status')->default(1)->after('document_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('investor_kyc_demat', function (Blueprint $table) {
            $table->dropColumn(['document_id', 'manage_status']);
        });
        Schema::rename('investor_kyc_demat', 'investor_demat_account');
    }
};
