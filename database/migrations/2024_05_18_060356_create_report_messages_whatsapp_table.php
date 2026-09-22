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
        Schema::create('report_messages_whatsapp', function (Blueprint $table) {
            $table->id();
            $table->text('template_name')->comment('received from thirdparty');
            $table->enum('template_type', ['media', 'text', 'image']);
            $table->integer('trycount')->default(0);
            $table->enum('status', ['pending', 'sent', 'failed']);
            $table->integer('response_code')->nullable();
            $table->text('response')->nullable();
            $table->string('destination_mobile_no', 12);
            $table->string('username')->comment('Name of the person who receives this message');
            $table->text('media')->nullable()->comment('Media url');
            $table->json('message_data')->nullable();
            $table->json('params')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_messages_whatsapp');
    }
};
