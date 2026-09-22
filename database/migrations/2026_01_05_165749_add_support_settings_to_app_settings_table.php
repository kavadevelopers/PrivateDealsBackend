<?php

use App\Models\AppSettingsModel;
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
        Schema::table('app_settings', function (Blueprint $table) {
            $settings = [
                ['key' => 'support_whatsapp_number', 'value' => '919876543210'],
                ['key' => 'support_email', 'value' => 'support@shuruup.com'],
                ['key' => 'support_phone', 'value' => '919876543210'],
            ];

            foreach ($settings as $setting) {
                AppSettingsModel::firstOrCreate(
                    ['key' => $setting['key']],
                    ['value' => $setting['value']]
                );
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('app_settings', function (Blueprint $table) {
            $keys = ['support_whatsapp_number', 'support_email', 'support_phone'];

            foreach ($keys as $key) {
                AppSettingsModel::where('key', $key)->delete();
            }
        });
    }
};
