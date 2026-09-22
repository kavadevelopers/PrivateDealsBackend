<?php

use App\Enums\InstrumentTypeEnum;
use App\Enums\InvestorTypeEnum;
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
        Schema::create('startup_manage_captable', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('startup_id');
            $table->unsignedBigInteger('round_id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile_number', 20)->nullable();
            $table->unsignedBigInteger('share')->default(0);
            $table->decimal('holding_percentage', 40, 2)->default(0);
            $table->enum('instrument_type', array_column(InstrumentTypeEnum::cases(), 'value'))->nullable();
            $table->enum('investor_type', array_column(InvestorTypeEnum::cases(), 'value'))->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('startup_manage_captable');
    }
};
