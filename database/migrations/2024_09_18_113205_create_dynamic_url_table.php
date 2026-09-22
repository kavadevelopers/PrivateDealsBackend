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
        Schema::create('_dynamic_url', function (Blueprint $table) {
            $table->id();
            $table->string('token_type')->nullable();
            $table->text('token')->nullable();
            $table->json('values')->nullable();
            $table->boolean('expired')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_dynamic_url');
    }
};
