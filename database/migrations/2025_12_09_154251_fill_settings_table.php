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
            $array = [
                ['key'      => 'pre_ipo_common_keywords', 'value' => ''],
            ];

            foreach ($array as $key => $value) {
                AppSettingsModel::create($value);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $array = [
            ['key'      => 'pre_ipo_common_keywords', 'value' => ''],
        ];

        foreach ($array as $key => $value) {
            AppSettingsModel::where('key', $value['key'])->delete();
        }
    }
};
