<?php

use App\Enums\Utills\CommunicationType;
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
            ['key'      => 'default_verification_code_type', 'value' => CommunicationType::sms]
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
            ['key'      => 'default_verification_code_type', 'value' => '']
        ];

        foreach ($array as $key => $value) {
            AppSettingsModel::where('key', $value['key'])->delete();
        }
    }
};
