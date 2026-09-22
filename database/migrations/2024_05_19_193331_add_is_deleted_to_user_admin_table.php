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
            $table->boolean('is_deleted')->default(0)->after('password');
            $table->boolean('is_blocked')->default(0)->after('is_deleted');
            $table->boolean('ask_password_change')->default(0)->after('is_blocked');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_admin', function (Blueprint $table) {
            $table->dropColumn('is_deleted');
            $table->dropColumn('is_blocked');
            $table->dropColumn('ask_password_change');
        });
    }
};
