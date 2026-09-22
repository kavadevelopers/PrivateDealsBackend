<?php

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
        Schema::create('seller_company_share_price', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->index();
            $table->unsignedBigInteger('seller_id')->index();
            $table->date('date');
            $table->decimal('sell_price', 40, 2);
            $table->decimal('buy_price', 40, 2)->nullable();
            $table->unsignedInteger('min_qty');
            $table->unsignedInteger('total_qty')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_company_share_price');
    }
};
