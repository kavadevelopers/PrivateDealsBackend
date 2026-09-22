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
        Schema::table('user_admin', function (Blueprint $table) {
            $table->uuid()->after('id');
            $table->string('profile_photo')->nullable()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_admin', function (Blueprint $table) {
            $table->dropColumn(['uuid', 'profile_photo']);
        });
    }
};
