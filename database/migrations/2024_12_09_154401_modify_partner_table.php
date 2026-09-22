<?php

use App\Enums\PartnerTypeEnum;
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
        Schema::table('partner', function (Blueprint $table) {
            $table->enum('type', array_column(PartnerTypeEnum::cases(), 'value'))->change();
            $table->enum('parent_type', array_column(PartnerTypeEnum::cases(), 'value'))->change()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partner', function (Blueprint $table) {
            
        });
    }
};
