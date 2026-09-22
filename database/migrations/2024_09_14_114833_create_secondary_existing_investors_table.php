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
        Schema::create('secondary_existing_investors', function (Blueprint $table) {
            $table->id();
            $table->enum('status', array_column(StatusEnum::cases(), 'value'));
            $table->unsignedBigInteger('buyer_id');
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('portfolio_id');
            $table->unsignedBigInteger('sell_request_id');
            $table->unsignedBigInteger('startup_id');
            $table->unsignedBigInteger('shares');
            $table->decimal('price', 40, 2);
            $table->dateTime('expired_at');
            $table->boolean('is_promoter');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('secondary_existing_investors');
    }
};
