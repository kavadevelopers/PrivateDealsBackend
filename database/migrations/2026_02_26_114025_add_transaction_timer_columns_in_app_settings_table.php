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
            $keys = [
                ['key' => 'peripo_market_open',                     'value' => null],
                ['key' => 'peripo_market_close',                    'value' => null],
                ['key' => 'peripo_admin_order_accept_hours',        'value' => null],
                ['key' => 'preipo_investor_order_completion_hours', 'value' => null],
                ['key' => 'preipo_share_tranfer_hours',             'value' => null],

            ];

            foreach ($keys as $item) {
                AppSettingsModel::firstOrCreate(['key' => $item['key']], ['value' => $item['value']]);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('app_settings', function (Blueprint $table) {
            AppSettingsModel::whereIn('key', [
                'peripo_market_open',
                'peripo_market_close',
                'peripo_admin_order_accept_hours',
                'preipo_investor_order_completion_hours',
                'preipo_share_tranfer_hours',
            ])->delete();
        });
    }
};
