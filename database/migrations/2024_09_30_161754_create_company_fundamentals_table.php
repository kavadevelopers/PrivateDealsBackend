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
        Schema::create('company_fundamentals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('lot_size')->nullable();
            $table->decimal('fifty_two_week_high', 40, 2)->default(0);
            $table->decimal('fifty_two_week_low', 40, 2)->default(0);
            $table->string('depository')->nullable();
            $table->string('pan_number')->nullable();
            $table->string('isin_number')->nullable();
            $table->string('cin_number')->nullable();
            $table->string('rta')->nullable();
            $table->string('market_cap')->nullable();
            $table->decimal('pe_ratio', 40, 2)->default(0);
            $table->decimal('pb_ratio', 40, 2)->default(0);
            $table->string('debt_to_equity')->nullable();
            $table->decimal('roe', 40, 2)->nullable();
            $table->decimal('book_value', 40, 2)->default(0);
            $table->decimal('face_value', 40, 2)->default(0);
            $table->string('total_shares')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_fundamentals');
    }
};
