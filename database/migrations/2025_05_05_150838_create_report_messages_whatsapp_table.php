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
            $table->string('mobile_country_code', 5)->default(91)->after('response');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_messages_whatsapp', function (Blueprint $table) {
            $table->dropColumn('mobile_country_code');
        });
    }
};
