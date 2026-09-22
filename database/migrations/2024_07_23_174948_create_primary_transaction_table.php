<?php

use App\Enums\InstrumentTypeEnum;
use App\Enums\PrimaryTransactionPaymentMode;
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
        Schema::create('primary_transaction', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('investor_id');
            $table->unsignedBigInteger('startup_id');
            $table->unsignedBigInteger('round_id');
            $table->unsignedBigInteger('mgt14_id');
            $table->unsignedBigInteger('pas3_id');
            $table->unsignedBigInteger('portfolio_id');
            $table->enum('instrument', array_column(InstrumentTypeEnum::cases(), 'value'));
            $table->string('offerletterno')->nullable();
            $table->decimal('shares', 40, 2)->default(0);
            $table->decimal('share_price', 40, 2)->default(0);
            $table->decimal('investment_amount', 40, 2)->default(0);
            $table->boolean('payment_status')->default(0);
            $table->enum('payment_mode', array_column(PrimaryTransactionPaymentMode::cases(), 'value'));
            $table->boolean('is_share_transfered')->default(0);
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('primary_transaction');
    }
};
