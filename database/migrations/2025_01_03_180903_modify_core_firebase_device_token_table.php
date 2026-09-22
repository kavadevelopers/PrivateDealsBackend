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
        Schema::table('core_firebase_device_token', function (Blueprint $table) {
            $table->enum('device', array_column(DeviceTypeEnum::cases(), 'value'))->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('core_firebase_device_token', function (Blueprint $table) {
            $table->enum('device', array_column(DeviceTypeEnum::cases(), 'value'))->change();
        });
    }
};
