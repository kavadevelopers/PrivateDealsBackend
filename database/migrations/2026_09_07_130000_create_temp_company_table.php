<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('temp_company', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('external_ref')->nullable()->index();
            $table->unsignedBigInteger('api_client_id')->nullable()->index();
            $table->unsignedBigInteger('matched_company_id')->nullable()->index();
            $table->enum('intent', ['create', 'update'])->default('create');
            $table->enum('status', ['pending', 'rejected', 'approved'])->default('pending')->index();

            $table->string('cin')->nullable()->index();
            $table->string('brand_name')->nullable();
            $table->string('company_name')->nullable();
            $table->text('about')->nullable();
            $table->string('logo')->nullable();
            $table->string('logo_url')->nullable();
            $table->text('keywords')->nullable();
            $table->text('negative_keywords')->nullable();
            $table->text('alternative_names')->nullable();
            $table->string('type')->nullable();
            $table->string('category')->nullable();
            $table->string('bg_color_code')->nullable();
            $table->string('sector_name')->nullable();
            $table->unsignedBigInteger('sector_id')->nullable();

            $table->decimal('min_investment_amount', 15, 2)->nullable();
            $table->decimal('commission', 8, 2)->nullable();
            $table->decimal('processing_fee_percentage', 8, 2)->nullable();

            $table->json('fundamentals')->nullable();
            $table->json('promoters')->nullable();
            $table->json('shareholders')->nullable();
            $table->json('events')->nullable();
            $table->json('financials')->nullable();

            $table->json('raw_payload')->nullable();
            $table->text('admin_notes')->nullable();
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('temp_company');
    }
};
