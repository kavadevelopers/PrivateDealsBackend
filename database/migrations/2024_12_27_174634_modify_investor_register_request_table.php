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
        Schema::table('investor_register_request', function (Blueprint $table) {
            $table->integer('is_converted')->default(0)->comment('0: Deleted, 1: Converted')->after('is_readed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investor_register_request', function (Blueprint $table) {
            $table->dropColumn('is_converted');
        });
    }
};
