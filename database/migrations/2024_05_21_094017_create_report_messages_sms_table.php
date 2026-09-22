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
        Schema::create('report_messages_sms', function (Blueprint $table) {
            $table->id();
            $table->integer('trycount')->default(0);
            $table->enum('type', ['event', 'regular'])->default('regular');
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
            $table->integer('response_code')->nullable();
            $table->text('response')->nullable();
            $table->string('destination_mobile_no', 12);
            $table->text('url')->nullable();
            $table->json('message_data')->nullable();
            $table->text('body')->nullable()->comment('Message body');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_messages_sms');
    }
};
