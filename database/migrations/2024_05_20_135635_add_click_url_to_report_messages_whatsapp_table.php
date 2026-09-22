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
            $table->text('click_url')->nullable()->after('media');
            $table->text('type')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_messages_whatsapp', function (Blueprint $table) {
            $table->dropColumn('click_url');
            $table->dropColumn('type');
        });
    }
};
