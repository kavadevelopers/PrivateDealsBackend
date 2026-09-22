<?php

use App\Enums\Utills\StatusEnum;
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
        Schema::table('startup_offerrequest', function (Blueprint $table) {
            $table->dropColumn('srn_no');
            $table->enum('status', array_column(StatusEnum::cases(), 'value'))->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('startup_offerrequest', function (Blueprint $table) {
            $table->text('srn_no')->nullable();
        });
    }
};
