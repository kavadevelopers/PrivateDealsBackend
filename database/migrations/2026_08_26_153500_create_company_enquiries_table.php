<?php

use App\Enums\CompanyEnquiryStatusEnum;
use App\Enums\CompanyEnquiryTypeEnum;
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
        Schema::create('company_enquiries', function (Blueprint $table) {
            $table->id();
            $table->uuid()->nullable();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('deal_id')->nullable();
            $table->enum('enquiry_type', array_column(CompanyEnquiryTypeEnum::cases(), 'value'));
            $table->unsignedBigInteger('user_id');
            $table->string('user_type');
            $table->unsignedInteger('quantity');
            $table->decimal('offer_price', 15, 2);
            $table->date('offer_valid_till')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', array_column(CompanyEnquiryStatusEnum::cases(), 'value'))
                ->default(CompanyEnquiryStatusEnum::pending->value);
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('company')->onDelete('cascade');
            $table->foreign('deal_id')->references('id')->on('company_deals')->onDelete('set null');
            $table->index(['company_id', 'deal_id']);
            $table->index(['user_id', 'user_type']);
            $table->index('status');
            $table->index('is_deleted');
            $table->index('enquiry_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_enquiries');
    }
};
