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
        Schema::create('portfolio_import', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('investor_id')->nullable();
            $table->enum('type',['startup','company']);
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('other_name')->nullable();
            $table->decimal('shares', 40, 2)->default(0);
            $table->decimal('share_price', 40, 2)->default(0);
            $table->date('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_import');
    }
};
