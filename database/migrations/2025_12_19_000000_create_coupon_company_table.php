<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupon_company', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coupon_id');
            $table->unsignedBigInteger('company_id');
            $table->timestamps();

            $table->unique(['coupon_id', 'company_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupon_company');
    }
};
