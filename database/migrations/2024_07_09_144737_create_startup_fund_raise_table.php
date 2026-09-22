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
        Schema::create('startup_fund_raise', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('round_id');
            $table->unsignedBigInteger('startup_id');
            $table->decimal('fund_requirement', 40, 2)->default(0);
            $table->text('fund_utilisation_details')->nullable();
            $table->decimal('current_fund_raise', 40, 2)->default(0);
            $table->json('committed_investors')->nullable();
            $table->decimal('funds_required_from_shuru', 40, 2)->default(0);
            $table->decimal('min_ticket_size', 40, 2)->default(0);
            $table->decimal('pre_money_valuation', 40, 2)->default(0);
            $table->text('pre_money_valuation_basis')->nullable();
            $table->text('instrument_and_conversion_condition')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('startup_fund_raise');
    }
};
