<?php

use App\Enums\Utills\DeviceTypeEnum;
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
        Schema::create('_app_version_control', function (Blueprint $table) {
            $table->id();
            $table->enum('device', array_column(DeviceTypeEnum::cases(), 'value'));
            $table->unsignedBigInteger('last_version_code')->default(0);
            $table->unsignedBigInteger('current_version_code')->default(0);
            $table->decimal('last_version', 4, 4)->default(0);
            $table->decimal('current_version', 4, 4)->default(0);
            $table->boolean('force_update')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_version_control');
    }
};
