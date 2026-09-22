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
        $array = [
            ['key'      => 'file_video_max_size', 'value' => '10'],
            ['key'      => 'file_video_extensions_allowed', 'value' => 'pdf,xlsx,docx,doc'],
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
            ['key'      => 'file_video_max_size', 'value' => '10'],
            ['key'      => 'file_video_extensions_allowed', 'value' => 'pdf,xlsx,docx,doc'],
        ];

        foreach ($array as $key => $value) {
            AppSettingsModel::where('key', $value['key'])->delete();
        }
    }
};
