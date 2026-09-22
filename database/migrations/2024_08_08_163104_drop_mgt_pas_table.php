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
        Schema::dropIfExists('startup_mgt14');
        Schema::dropIfExists('startup_pas3');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
