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
        Schema::create('secondary_sell_request', function (Blueprint $table) {
            $table->id();
            $table->integer('status');
            $table->enum('instrument', array_column(InstrumentTypeEnum::cases(), 'value'));
            $table->unsignedBigInteger('startup_id');
            $table->unsignedBigInteger('portfolio_id');
            $table->unsignedBigInteger('investor_id');
            $table->integer('shares');
            $table->decimal('price', 40, 2);
            $table->decimal('purchase_price', 40, 2)->default(0);
            $table->decimal('current_price', 40, 2)->default(0);
            $table->decimal('last_traded_price', 40, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('secondary_sell_request');
    }
};
