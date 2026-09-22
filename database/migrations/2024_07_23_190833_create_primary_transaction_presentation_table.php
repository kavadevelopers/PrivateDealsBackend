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
        Schema::create('primary_transaction_presentation', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mandate_id');
            $table->unsignedBigInteger('presentation_id');
            $table->unsignedBigInteger('transaction_id');
            $table->decimal('amount', 40, 2)->default(0);
            $table->enum('status', array_column(StatusEnum::cases(), 'value'));
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('primary_transaction_presentation');
    }
};
