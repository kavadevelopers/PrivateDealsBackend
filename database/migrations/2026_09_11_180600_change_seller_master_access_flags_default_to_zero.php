<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Column defaults must be 0; existing rows were already set to 1
     * by 2026_09_11_175500_add_access_flags_to_seller_master_table.
     */
    public function up(): void
    {
        Schema::table('seller_master', function (Blueprint $table) {
            $table->boolean('is_primary_access')->default(0)->change();
            $table->boolean('is_secondary_access')->default(0)->change();
            $table->boolean('is_preipo_access')->default(0)->change();
        });
    }

    public function down(): void
    {
        Schema::table('seller_master', function (Blueprint $table) {
            $table->boolean('is_primary_access')->default(1)->change();
            $table->boolean('is_secondary_access')->default(1)->change();
            $table->boolean('is_preipo_access')->default(1)->change();
        });
    }
};
