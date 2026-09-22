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
        Schema::create('api_logs', function (Blueprint $table) {
            $table->id();
            $table->string('url')->nullable();
            $table->string('headtoken')->nullable();
            $table->string('deviceid')->nullable();
            $table->string('devicetype')->nullable();
            $table->string('userid')->nullable();
            $table->string('usertype')->nullable();
            $table->string('authorization')->nullable();
            $table->string('useragent')->nullable();
            $table->json('params')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_logs');
    }
};
