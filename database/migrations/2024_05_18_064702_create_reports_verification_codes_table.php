<?php

use App\Enums\Utills\CodeVerificationTypeEnum;
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
        Schema::create('reports_verification_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('user_type')->comment('Store model path here. User should be any like startup or Admin');
            $table->enum('notification_type', ['sms', 'email', 'whatsapp']);
            $table->string('code', 10);
            $table->enum('code_type', array_column(CodeVerificationTypeEnum::cases(), 'value'));
            $table->boolean('is_used')->default(0);
            $table->dateTime('expired_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports_verification_codes');
    }
};
