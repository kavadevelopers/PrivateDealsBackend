<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSharePriceToStartupRoundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('startup_round', function (Blueprint $table) {
            $table->decimal('share_price', 15, 2)->nullable()->after('round_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('startup_round', function (Blueprint $table) {
            $table->dropColumn('share_price');
        });
    }
}

