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
        Schema::table('startup', function (Blueprint $table) {
            $table->unsignedBigInteger('industry_segment')->nullable()->after('sector_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('startup', function (Blueprint $table) {
            $table->dropColumn('industry_segment');
        });
    }
};
