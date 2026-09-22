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
        Schema::table('investor', function (Blueprint $table) {
            $table->boolean('ekyc_kyc_status')->default(false)->after('preipo_kyc_status');
            $table->boolean('manual_kyc_status')->default(false)->after('ekyc_kyc_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investor', function (Blueprint $table) {
            $table->dropColumn(['ekyc_kyc_status', 'manual_kyc_status']);
        });
    }
};
