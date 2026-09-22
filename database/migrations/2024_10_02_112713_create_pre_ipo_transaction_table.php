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
        Schema::create('pre_ipo_transaction', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('investor_id');
            $table->unsignedBigInteger('company_id');
            $table->integer('status')->default(0);
            $table->unsignedBigInteger('shares')->default(0);
            $table->decimal('share_price', 40, 2)->default(0);
            $table->decimal('investment_amount', 40, 2)->default(0);
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
