<?php

use App\Enums\StartupPrimaryRoundStatusEnum;
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
            $table->enum('round_status', array_column(StartupPrimaryRoundStatusEnum::cases(), 'value'))->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('startup_round', function (Blueprint $table) {
            $table->dropColumn('round_status');
        });
    }
};
