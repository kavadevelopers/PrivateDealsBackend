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
        Schema::table('broadcast_whatsapp', function (Blueprint $table) {
            Schema::rename('whatsapp_broadcast', 'broadcast_whatsapp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('broadcast_whatsapp', function (Blueprint $table) {
            Schema::rename('broadcast_whatsapp', 'whatsapp_broadcast');
        });
    }
};
