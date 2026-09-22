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
        Schema::table('investor_kyc_aadhar', function (Blueprint $table) {
            $table->unsignedBigInteger('front_document_id')->nullable()->after('status');
            $table->unsignedBigInteger('back_document_id')->nullable()->after('front_document_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investor_kyc_aadhar', function (Blueprint $table) {
            $table->dropColumn('front_document_id');
            $table->dropColumn('back_document_id');
        });
    }
};
