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
        Schema::create('startup_legal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('startup_id');
            $table->string('company_pan', 10)->nullable();
            $table->string('cin', 30)->nullable();
            $table->string('bank_ac_name')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_ac_no')->nullable();
            $table->string('bank_ifsc')->nullable();
            $table->string('bank_uan')->nullable();
            $table->string('dpiit')->nullable();
            $table->date('incorporation_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('startup_legal');
    }
};
