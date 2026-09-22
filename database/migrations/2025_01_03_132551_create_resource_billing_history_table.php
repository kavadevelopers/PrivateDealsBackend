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
        Schema::create('resource_billing_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resource_billing_id');
            $table->string('file');
            $table->date('purchase_date');
            $table->date('expire_date');
            $table->decimal('amount', 40, 2);
            $table->decimal('renewal_amount', 40, 2);
            $table->boolean('is_deleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource_billing_history');
    }
};
