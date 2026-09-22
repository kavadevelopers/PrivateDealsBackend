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
        Schema::table('bank_details', function (Blueprint $table) {
            $table->renameColumn('bank_id', 'bank_name');
        });
        Schema::table('bank_details', function (Blueprint $table) {
            $table->string('bank_name')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bank_details', function (Blueprint $table) {
            $table->integer('bank_name')->change();
        });

        Schema::table('bank_details', function (Blueprint $table) {
            $table->renameColumn('bank_name', 'bank_id');
        });
    }
};
