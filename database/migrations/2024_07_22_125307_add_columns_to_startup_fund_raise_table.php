<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToStartupFundRaiseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('startup_fund_raise', function (Blueprint $table) {
            $table->date('prev_fund_raised_date')->nullable()->after('instrument_and_conversion_condition'); // Adjust the column_name if needed
            $table->string('prev_fund_raise_investor_name', 255)->nullable()->after('prev_fund_raised_date');
            $table->decimal('previous_fund_raised_amount', 15, 2)->nullable()->after('prev_fund_raise_investor_name');
            $table->decimal('valuation_of_previous_round', 15, 2)->nullable()->after('previous_fund_raised_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('startup_fund_raise', function (Blueprint $table) {
            $table->dropColumn(['prev_fund_raised_date', 'prev_fund_raise_investor_name', 'previous_fund_raised_amount', 'valuation_of_previous_round']);
        });
    }
}
