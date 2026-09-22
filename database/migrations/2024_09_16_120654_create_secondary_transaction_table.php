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
        Schema::create('secondary_transaction', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('status')->default(0);
            $table->unsignedBigInteger('startup_id');
            $table->unsignedBigInteger('portfolio_id');
            $table->unsignedBigInteger('buyer_id');
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('sell_request_id');
            $table->enum('instrument', array_column(InstrumentTypeEnum::cases(), 'value'));
            $table->unsignedBigInteger('shares')->default(0);
            $table->decimal('share_price', 40, 2)->default(0);
            $table->decimal('investment_amount', 40, 2)->default(0);
            $table->boolean('is_promoter')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('secondary_transaction');
    }
};
