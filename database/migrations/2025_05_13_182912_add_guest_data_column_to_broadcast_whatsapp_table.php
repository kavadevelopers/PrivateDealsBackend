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
            $table->json('guest_data')->nullable()->after('partners_ids');
            $table->boolean('register_guest')->default(false)->after('guest_data');
            $table->string('default_button_response')->nullable()->after('register_guest');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('broadcast_whatsapp', function (Blueprint $table) {
            $table->dropColumn(['guest_data', 'register_guest', 'default_button_response']);
        });
    }
};
