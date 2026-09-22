<?php

use App\Models\AppSettingsModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $array = [
            ['key'      => 'admin_panel_table_pagination_limit', 'value' => '10']
        ];

        foreach ($array as $key => $value) {
            AppSettingsModel::create($value);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $array = [
            ['key'      => 'admin_panel_table_pagination_limit', 'value' => '10']
        ];

        foreach ($array as $key => $value) {
            AppSettingsModel::where('key', $value['key'])->delete();
        }
    }
};
