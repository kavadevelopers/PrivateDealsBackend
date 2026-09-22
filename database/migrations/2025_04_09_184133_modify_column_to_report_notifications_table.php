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
        Schema::table('report_notifications', function (Blueprint $table) {
            $table->json('data')->nullable()->change();
            $table->json('response')->nullable()->change();
            $table->text('redirection')->nullable()->change()->comment('Redirection URL on click');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_notifications', function (Blueprint $table) {
            //
        });
    }
};
