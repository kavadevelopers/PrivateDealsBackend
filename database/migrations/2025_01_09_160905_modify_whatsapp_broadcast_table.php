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
        Schema::table('whatsapp_broadcast', function (Blueprint $table) {
            $table->string('template_id')->nullable()->change();
            $table->json('investors_ids')->after('variables')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('whatsapp_broadcast', function (Blueprint $table) {
            $table->string('template_id')->nullable()->change();
            $table->dropColumn('investors_ids');
        });
    }
};
