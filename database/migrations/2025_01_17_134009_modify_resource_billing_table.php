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
        Schema::table('resource_billing', function (Blueprint $table) {
            $table->enum('resource_type',array_column(ResoureceTypeEnum::cases(),'value'))->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resource_billing', function (Blueprint $table) {
            $table->enum('resource_type',array_column(ResoureceTypeEnum::cases(),'value'))->change();
        });
    }
};
