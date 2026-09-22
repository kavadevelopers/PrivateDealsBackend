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
            $table->boolean('resend_clicked')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('broadcast_whatsapp', function (Blueprint $table) {
            $table->dropColumn('resend_clicked');
        });
    }
};
