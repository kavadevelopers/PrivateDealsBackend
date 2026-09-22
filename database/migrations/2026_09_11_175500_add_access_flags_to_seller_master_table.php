<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Mirrors investor feature access flags on seller_master.
     * All existing sellers get full access (true).
     */
    public function up(): void
    {
        Schema::table('seller_master', function (Blueprint $table) {
            $table->boolean('is_primary_access')->default(0)->after('ask_password_change');
            $table->boolean('is_secondary_access')->default(0)->after('is_primary_access');
            $table->boolean('is_preipo_access')->default(0)->after('is_secondary_access');
        });

        // Existing sellers keep full access after the column add.
        DB::table('seller_master')->update([
            'is_primary_access' => 1,
            'is_secondary_access' => 1,
            'is_preipo_access' => 1,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seller_master', function (Blueprint $table) {
            $table->dropColumn([
                'is_primary_access',
                'is_secondary_access',
                'is_preipo_access',
            ]);
        });
    }
};
