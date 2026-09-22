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
        Schema::create('startup_mgt14', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('startup_id');
            $table->unsignedBigInteger('round_id');
            $table->text('srn_no')->nullable();
            $table->string('mgt14_challan_file')->nullable();
            $table->string('mgt14_zip_file')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('startup_mgt14');
    }
};
