<?php

use App\Enums\DocumentTypeEnum;
use App\Enums\PrimaryTransactionTypeEnum;
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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('api_id');
            $table->string('path');
            $table->string('signed_path')->nullable();
            $table->boolean('status')->default(0);
            $table->enum('type', array_column(DocumentTypeEnum::cases(), 'value'));
            $table->json('user_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
