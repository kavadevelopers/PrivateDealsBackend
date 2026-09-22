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
        Schema::table('startup_details', function (Blueprint $table) {
            $table->string('pitch_deck_file')->nullable()->after('dpiit_startup_certificate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('startup_details', function (Blueprint $table) {
            $table->dropColumn('pitch_deck_file');
        });
    }
};
