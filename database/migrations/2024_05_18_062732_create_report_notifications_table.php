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
        Schema::create('report_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('user_type')->comment('Store model path here. User should be any like startup or Admin');
            $table->text('title');
            $table->text('body');
            $table->json('data');
            $table->text('redirection')->comment('Redirection URL on click');
            $table->boolean('is_read')->default(0)->comment('Flag to see if notification is read or not');
            $table->boolean('is_posted')->default(0)->comment('Flag to see if posted on list or not');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_notifications');
    }
};
