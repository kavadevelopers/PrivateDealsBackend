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
        Schema::table('investor', function (Blueprint $table) {
            $table->boolean('is_demo')->after('is_deleted')->default(false);
        });

        Schema::table('partner', function (Blueprint $table) {
            $table->boolean('is_demo')->after('is_deleted')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investor', function (Blueprint $table) {
            $table->dropColumn('is_demo');
        });

        Schema::table('partner', function (Blueprint $table) {
            $table->dropColumn('is_demo');
        });
    }
};
