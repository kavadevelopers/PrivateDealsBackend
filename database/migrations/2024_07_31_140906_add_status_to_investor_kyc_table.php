<?php

use App\Enums\Utills\StatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToInvestorKycTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investor_kyc', function (Blueprint $table) {
            $table->enum('status', array_column(StatusEnum::cases(), 'value'))->nullable()->after('pan_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('investor_kyc', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
