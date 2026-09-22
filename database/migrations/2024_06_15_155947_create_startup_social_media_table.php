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
        Schema::create('startup_social_media', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('startup_id'); //startup table
            $table->unsignedBigInteger('master_socialmedia_link_id')->nullable(); //startup table
            $table->text('link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('startup_social_media');
    }
};
