<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHighlightsAndIdeaToStartupOtherDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('startup_other_details', function (Blueprint $table) {
            // Add new columns for highlights and idea
            $table->text('highlights')->nullable()->after('startup_failures_successful_exits');
            $table->text('idea')->nullable()->after('highlights');
            $table->text('key_information')->nullable()->after('idea');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('startup_other_details', function (Blueprint $table) {
            // Drop the columns if rolling back
            $table->dropColumn(['highlights', 'idea','key_information']);
        });
    }
}
