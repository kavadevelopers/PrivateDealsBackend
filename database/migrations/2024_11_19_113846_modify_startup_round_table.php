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
        Schema::table('startup_round', function (Blueprint $table) {
            $table->decimal('equity_offered', 40, 2)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('startup_round', function (Blueprint $table) {
            $table->decimal('equity_offered', 3, 2)->default(0)->change();
        });
    }
};
