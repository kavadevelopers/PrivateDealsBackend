<?php

use App\Enums\InstrumentTypeEnum;
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
            $table->enum('instrument', array_column(InstrumentTypeEnum::cases(), 'value'))->nullable()->after('shuru_commission');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('startup_round', function (Blueprint $table) {
            $table->dropColumn('instrument');
        });
    }
};
