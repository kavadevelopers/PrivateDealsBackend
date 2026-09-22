<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * - Makes user_id nullable (to support guest/anonymous users)
     * - Makes user_type nullable (to support guest/anonymous users)
     * - Adds version column (nullable string) to track app version
     */
    public function up(): void
    {
        Schema::table('core_firebase_device_token', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->string('user_type')->nullable()->change();
            $table->string('version')->nullable()->after('token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('core_firebase_device_token', function (Blueprint $table) {
            $table->dropColumn('version');
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->string('user_type')->nullable(false)->change();
        });
    }
};
