<?php

use App\Enums\StartupRoundTypeEnum;
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
        Schema::create('startup_round', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('startup_id');
            $table->string('name');
            $table->enum('round_type', array_column(StartupRoundTypeEnum::cases(), 'value'));
            $table->decimal('shuru_commission', 40, 2)->default(0);
            $table->boolean('is_deleted')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('startup_round');
    }
};
