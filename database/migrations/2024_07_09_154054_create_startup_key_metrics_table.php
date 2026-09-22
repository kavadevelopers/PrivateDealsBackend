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
        Schema::create('startup_key_metrics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('round_id');
            $table->unsignedBigInteger('startup_id');
            $table->decimal('founder_capital_contribution', 40, 2)->default(0);
            $table->decimal('monthly_revenue_run_rate', 40, 2)->default(0);
            $table->decimal('annualized_revenue_run_rate', 40, 2)->default(0);
            $table->text('traction_metrics')->nullable();
            $table->decimal('current_monthly_burn', 40, 2)->default(0);
            $table->decimal('current_cash_balance', 40, 2)->default(0);
            $table->string('runway_months')->nullable();
            $table->text('competitors')->nullable();
            $table->text('key_usp_differentiator_entry_barrier')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('startup_key_metrics');
    }
};
