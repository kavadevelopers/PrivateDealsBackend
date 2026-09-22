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
            ['key'      => 'google_recaptcha_sitekey', 'value' => ''],
            ['key'      => 'google_recaptcha_secret', 'value' => ''],
            ['key'      => 'branding_content_contact_email', 'value' => ''],
            ['key'      => 'branding_content_contact_mobile', 'value' => ''],
            ['key'      => 'branding_content_contact_address', 'value' => ''],
            ['key'      => 'branding_content_google_map_url', 'value' => ''],
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
            ['key'      => 'google_recaptcha_sitekey', 'value' => ''],
            ['key'      => 'google_recaptcha_secret', 'value' => ''],
            ['key'      => 'branding_content_contact_email', 'value' => ''],
            ['key'      => 'branding_content_contact_mobile', 'value' => ''],
            ['key'      => 'branding_content_contact_address', 'value' => ''],
            ['key'      => 'branding_content_google_map_url', 'value' => ''],
        ];

        foreach ($array as $key => $value) {
            AppSettingsModel::where('key', $value['key'])->delete();
        }
    }
};
