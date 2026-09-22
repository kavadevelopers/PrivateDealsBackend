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
        Schema::create('cms_faqs', function (Blueprint $table) {
            $table->id();
            $table->uuid()->nullable();
            $table->text('question')->nullable()->default(null);
            $table->text('answer')->nullable()->default(null);
            $table->string('display_order', 255)->nullable()->default(null);
            $table->boolean('is_deleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_faqs');
    }
};
