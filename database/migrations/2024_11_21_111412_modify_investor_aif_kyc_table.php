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
        Schema::table('investor_aif_kyc', function (Blueprint $table) {
            $table->boolean('ppm_signed')->after('notes')->default(0);
            $table->boolean('ca_signed')->after('ppm_signed')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investor_aif_kyc', function (Blueprint $table) {
            $table->dropColumn('ppm_signed');
            $table->dropColumn('ca_signed');
        });
    }
};
