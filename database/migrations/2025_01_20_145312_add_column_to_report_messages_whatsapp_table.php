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
            $table->string('message_id')->nullable()->after('broadcast_id');
            $table->enum('status',['pending','send','failed','readed'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_messages_whatsapp', function (Blueprint $table) {
            $table->dropColumn('message_id');
            $table->enum('status',['pending','send','failed'])->change();
        });
    }
};
