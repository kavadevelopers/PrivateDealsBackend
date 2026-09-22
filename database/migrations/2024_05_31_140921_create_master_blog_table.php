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
        Schema::create('master_blog', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->default(1)->comment('1 blog,2 thirdparty link');
            $table->text('banner')->nullable();
            $table->text('title');
            $table->text('short_description')->nullable();
            $table->text('long_description')->nullable();
            $table->integer('display_order')->nullable();
            $table->boolean('is_deleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_blog');
    }
};
