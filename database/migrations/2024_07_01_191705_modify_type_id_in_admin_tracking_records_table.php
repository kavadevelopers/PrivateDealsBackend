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
        Schema::table('admin_tracking_records', function (Blueprint $table) {
            $table->unsignedBigInteger('type_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_tracking_records', function (Blueprint $table) {
            $table->unsignedBigInteger('type_id')->change();
        });
    }
};
