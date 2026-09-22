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
        Schema::create('master_pages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('banner')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_display_banner')->default(1);
            $table->boolean('is_display_title')->default(1);
            $table->boolean('is_deleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_pages');
    }
};
