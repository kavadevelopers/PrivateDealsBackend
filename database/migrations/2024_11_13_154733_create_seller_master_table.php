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
        Schema::create('seller_master', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('cin')->nullable();
            $table->string('pan');
            $table->string('company_name');
            $table->text('address');
            $table->string('dp_id');
            $table->string('client_id');
            $table->string('bank_name');
            $table->string('account_number');
            $table->string('ifsc');
            $table->string('branch');
            $table->boolean('is_deleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_master');
    }
};
