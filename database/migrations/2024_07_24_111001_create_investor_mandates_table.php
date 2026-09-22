<?php

use App\Enums\BankAccountTypeEnum;
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
        Schema::create('investor_mandates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('investor_id');
            $table->unsignedBigInteger('mandate_id');
            $table->unsignedBigInteger('bank_id');
            $table->string('umrn_no')->nullable();
            $table->string('state')->nullable();
            $table->decimal('amount', 40, 2)->default(0);
            $table->string('bank_account_no')->nullable();
            $table->enum('bank_account_type', array_column(BankAccountTypeEnum::cases(), 'value'));
            $table->string('bank_ifsc_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investor_mandates');
    }
};
