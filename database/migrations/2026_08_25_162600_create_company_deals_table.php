<?php

use App\Enums\CompanyDealStatusEnum;
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
        Schema::create('company_deals', function (Blueprint $table) {
            $table->id();
            $table->uuid()->nullable();
            $table->unsignedBigInteger('company_id');
            $table->unsignedInteger('available_quantity');
            $table->decimal('share_price', 15, 2);
            $table->unsignedInteger('minimum_qty');
            $table->decimal('processing_fee_percentage', 5, 2)->default(2.00);
            $table->enum('status', array_column(CompanyDealStatusEnum::cases(), 'value'))
                ->default(CompanyDealStatusEnum::available->value);
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('company')->onDelete('cascade');
            $table->index('company_id');
            $table->index('status');
            $table->index('is_deleted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_deals');
    }
};
