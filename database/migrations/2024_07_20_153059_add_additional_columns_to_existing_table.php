<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalColumnsToExistingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('startup_details', function (Blueprint $table) {
            $table->string('financial_projection')->nullable();
            $table->string('dd_report')->nullable();
            $table->string('valuation_report')->nullable();
            $table->string('dpiit_certificate')->nullable();
            $table->string('shuruup_research_report')->nullable();
            $table->string('pitch_video')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('startup_details', function (Blueprint $table) {
            $table->dropColumn('financial_projection');
            $table->dropColumn('dd_report');
            $table->dropColumn('valuation_report');
            $table->dropColumn('dpiit_certificate');
            $table->dropColumn('shuruup_research_report');
            $table->dropColumn('pitch_video');
        }); 
    }
}
