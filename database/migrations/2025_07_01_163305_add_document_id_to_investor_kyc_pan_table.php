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
        Schema::table('investor_kyc_pan', function (Blueprint $table) {
            $table->unsignedBigInteger('document_id')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investor_kyc_pan', function (Blueprint $table) {
            $table->dropColumn('document_id');
        });
    }
};
