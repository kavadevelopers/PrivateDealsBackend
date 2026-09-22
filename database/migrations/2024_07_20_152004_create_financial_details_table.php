<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('startup_financial_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('start_id');
            $table->unsignedBigInteger('round_id');
            $table->year('year');
            $table->decimal('net_revenue', 15, 2)->nullable();
            $table->decimal('ebitda', 15, 2)->nullable();
            $table->decimal('pat', 15, 2)->nullable();
            $table->date('raised_date')->nullable();
            $table->string('investor_name')->nullable();
            $table->decimal('previous_fund_raised_amount', 15, 2)->nullable();
            $table->decimal('valuation_of_previous_round', 15, 2)->nullable();
            $table->decimal('revenue_expected', 15, 2)->nullable();
            $table->decimal('current_fy_closing_expense', 15, 2)->nullable();
            $table->decimal('current_fy_closing_ebitda', 15, 2)->nullable();
            $table->decimal('current_fy_closing_pat', 15, 2)->nullable();
            $table->decimal('next_fy_revenue', 15, 2)->nullable();
            $table->decimal('next_fy_expense', 15, 2)->nullable();
            $table->decimal('next_fy_ebitda', 15, 2)->nullable();
            $table->decimal('next_fy_pat', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('startup_financial_details');
    }
}
