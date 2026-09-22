<?php

use App\Enums\PreIpoCategoryEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('company', function (Blueprint $table) {
            $table->enum(
                'category',
                array_column(PreIpoCategoryEnum::cases(), 'value')
            )->nullable()->default(null)->change();
        });
    }

    public function down(): void
    {
        Schema::table('company', function (Blueprint $table) {
            $table->enum(
                'category',
                array_column(PreIpoCategoryEnum::cases(), 'value')
            )->default(PreIpoCategoryEnum::trending->value)->change();
        });
    }
};
