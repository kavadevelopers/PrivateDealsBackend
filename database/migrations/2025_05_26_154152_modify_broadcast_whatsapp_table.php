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
            $table->string('broadcast_id')->after('id');
            $table->unsignedBigInteger('connected_broadcast_id')->nullable()->after('broadcast_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('broadcast_whatsapp', function (Blueprint $table) {
            $table->dropColumn('broadcast_id');
            $table->dropColumn('connected_broadcast_id');
        });
    }
};
