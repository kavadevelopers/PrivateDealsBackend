<?php

use App\Enums\Utills\StatusEnum;
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
        Schema::create('primary_transaction_mgt14', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('startup_id');
            $table->unsignedBigInteger('round_id');
            $table->string('srn_no')->nullable();
            $table->string('zip')->nullable();
            $table->string('challan')->nullable();
            $table->json('meta')->nullable();
            $table->enum('status', array_column(StatusEnum::cases(), 'value'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('primary_transaction_mgt14');
    }
};
