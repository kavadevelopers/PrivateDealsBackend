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
        Schema::create('pre_ipo_transaction', function (Blueprint $table) {
            $table->id();
            $table->integer('status')->default(0);
            $table->unsignedBigInteger('investor_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('portfolio_id')->nullable();
            $table->unsignedBigInteger('seller_id')->nullable();
            $table->unsignedBigInteger('shares')->default(0);
            $table->decimal('share_price', 40, 2)->default(0);
            $table->decimal('distributer_price', 40, 2)->default(0);
            $table->decimal('investment_amount', 40, 2)->default(0);
            $table->boolean('is_distributer')->default(0);
            $table->enum('instrument', array_column(InstrumentTypeEnum::cases(), 'value'));
            $table->enum('payment_mode', array_column(PrimaryTransactionPaymentMode::cases(), 'value'));
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
        Schema::dropIfExists('pre_ipo_transaction');
    }
};
