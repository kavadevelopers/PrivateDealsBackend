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
                ['key' => 'coupon_referrer_coupon_id',  'value' => null],
                ['key' => 'coupon_referred_coupon_id',  'value' => null],
                ['key' => 'coupon_kyc_coupon_id',       'value' => null],
                ['key' => 'coupon_new_user_coupon_id',  'value' => null],
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
                'coupon_referrer_coupon_id',
                'coupon_referred_coupon_id',
                'coupon_kyc_coupon_id',
                'coupon_new_user_coupon_id',
            ])->delete();
        });
    }
};
