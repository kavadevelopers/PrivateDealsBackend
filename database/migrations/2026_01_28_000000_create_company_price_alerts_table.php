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
        Schema::create('company_price_alerts', function (Blueprint $table) {
            $table->id();

            // Relationships (no foreign key constraints, as requested)
            $table->unsignedBigInteger('investor_id');
            $table->unsignedBigInteger('company_id');

            // Direction: up = alert when price moves up to/above target, down = moves down to/below target
            $table->string('direction', 10); // 'up' | 'down'

            // Target price for alert (based on company share price)
            $table->decimal('target_price', 40, 2);

            // Alert lifecycle flags
            $table->boolean('is_active')->default(true);
            $table->boolean('is_triggered')->default(false);
            $table->timestamp('triggered_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_price_alerts');
    }
};
