<?php

use App\Enums\SendToUserTypeEnum;
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
        Schema::create('broadcast_notification', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body')->nullable();
            $table->text('image')->nullable();
            $table->json('investors_ids')->nullable();
            $table->json('partners_ids')->nullable();
            $table->boolean('is_deleted')->default(0);
            $table->enum('send_to',array_column(SendToUserTypeEnum::cases(),'value'));
            $table->string('topic')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('broadcast_notification');
    }
};
