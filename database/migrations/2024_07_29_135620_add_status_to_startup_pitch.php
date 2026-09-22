<?php

use App\Enums\Utills\StatusEnum;
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
        Schema::table('startup_pitch', function (Blueprint $table) {
            $table->enum('status', array_column(StatusEnum::cases(), 'value'))->default(StatusEnum::pending)->after('startup_round_id');
        });

       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('startup_pitch', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
