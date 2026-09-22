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
        Schema::table('investor_kyc', function (Blueprint $table) {
            $table->string('cml_image')->nullable()->after('pan_image');
            $table->string('cheque_image')->nullable()->after('cml_image');
            $table->text('notes')->nullable()->after('cheque_image');
            $table->unsignedBigInteger('created_by')->nullable()->after('status');
            $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investor_kyc', function (Blueprint $table) {
            $table->dropColumn('cml_image');
            $table->dropColumn('cheque_image');
            $table->dropColumn('notes');
            $table->dropColumn('created_by');
            $table->dropColumn('updated_by');
        });
    }
};
