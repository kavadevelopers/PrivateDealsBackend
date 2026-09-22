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
            $table->boolean('is_primary_access')->default(1)->after('updated_by');
            $table->boolean('is_secondary_access')->default(1)->after('is_primary_access');
            $table->boolean('is_preipo_access')->default(0)->after('is_secondary_access');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investor', function (Blueprint $table) {
            $table->dropColumn('is_primary_access');
            $table->dropColumn('is_secondary_access');
            $table->dropColumn('is_preipo_access');
        });
    }
};
