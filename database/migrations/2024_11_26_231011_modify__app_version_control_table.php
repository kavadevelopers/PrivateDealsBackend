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
        Schema::table('_app_version_control', function (Blueprint $table) {
            $table->string('last_version')->change()->default(0);
            $table->string('current_version')->change()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('_app_version_control', function (Blueprint $table) {
            $table->string('last_version')->change();
            $table->string('current_version')->change();
        });
    }
};
