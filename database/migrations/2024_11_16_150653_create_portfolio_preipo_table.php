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
        Schema::create('portfolio_preipo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('investor_id');
            $table->unsignedBigInteger('company_id');
            $table->decimal('shares', 40, 2)->default(0);
            $table->decimal('purchase_price', 40, 2)->default(0);
            $table->decimal('investment_amount', 40, 2)->default(0);
            $table->enum('instrument', array_column(InstrumentTypeEnum::cases(), 'value'));
            $table->boolean('is_share_transfered')->default(0);
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
        Schema::dropIfExists('portfolio_preipo');
    }
};
