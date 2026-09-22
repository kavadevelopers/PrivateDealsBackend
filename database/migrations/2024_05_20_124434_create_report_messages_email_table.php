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
        Schema::create('report_messages_email', function (Blueprint $table) {
            $table->id();
            $table->integer('trycount')->default(0);
            $table->enum('type', ['event', 'regular'])->default('regular');
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
            $table->integer('response_code')->nullable();
            $table->text('response')->nullable();
            $table->text('subject')->nullable();
            $table->text('destination_emails')->nullable()->comment('Comma separated emails');
            $table->longText('body')->nullable()->comment('Body html');
            $table->json('attachments')->nullable()->comment('Array of attachments as json');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_messages_email');
    }
};
