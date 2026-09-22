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
        Schema::create('pre_ipo_sell_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('status');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('portfolio_id');
            $table->unsignedBigInteger('investor_id');
            $table->integer('shares');
            $table->decimal('price', 40, 2);
            $table->decimal('purchase_price', 40, 2)->default(0);
            $table->decimal('current_price', 40, 2)->default(0);
            $table->decimal('last_traded_price', 40, 2)->default(0);
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_ipo_sell_requests');
    }
};
