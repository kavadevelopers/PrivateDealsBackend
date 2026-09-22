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
        Schema::create('company_grab_opportunity_slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->integer('slot_number')->comment('1, 2, or 3');
            $table->decimal('min_amount', 15, 2)->comment('Minimum amount for this slot');
            $table->decimal('max_amount', 15, 2)->nullable()->comment('Maximum amount for this slot (null for slot 3)');
            $table->decimal('percentage', 5, 2)->default(0)->comment('Percentage discount/addition');
            $table->timestamps();

            $table->unique(['company_id', 'slot_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_grab_opportunity_slots');
    }
};
