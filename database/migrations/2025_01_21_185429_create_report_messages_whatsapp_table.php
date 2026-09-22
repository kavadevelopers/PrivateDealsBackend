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
        Schema::table('report_messages_whatsapp', function (Blueprint $table) {
            $table->unsignedBigInteger(column: 'reference_id')->after('id')->nullable();
            $table->string('reference_model')->after('reference_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_messages_whatsapp', function (Blueprint $table) {
            $table->dropColumn(['reference_id','reference_model']);
        });
    }
};
