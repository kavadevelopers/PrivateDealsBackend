<?php

use App\Enums\ResoureceTypeEnum;
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
        Schema::create('resource_billing', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->enum('resourece_type',array_column(ResoureceTypeEnum::cases(),'value'));
            $table->string('company');
            $table->text('description');
            $table->date('purchase_date');
            $table->date('renewal_date');
            $table->boolean('status')->default(0);
            $table->integer('time_period')->comment('Time period in months');
            $table->boolean('is_recurring')->default(0);
            $table->decimal('amount', 40, 2);
            $table->decimal('renewal_amount', 40, 2);
            $table->boolean('is_deleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource_billing');
    }
};
