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
        Schema::create('bonus_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('split_ratio');
            $table->date('split_date');
            $table->decimal('multiplier', 8, 4);
            $table->json('before_split');
            $table->json('after_split');
            $table->integer('affected_portfolios')->default(0);
            $table->enum('status', ['applied', 'reverted'])->default('applied');
            $table->timestamp('applied_at');
            $table->timestamp('reverted_at')->nullable();
            $table->timestamps();
            $table->index(['company_id', 'split_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bonus_history');
    }
};
