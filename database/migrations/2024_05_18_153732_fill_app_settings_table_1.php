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
            ['key'      => 'app_name', 'value' => 'ShruuUp V4'],
            ['key'      => 'smtp_mail_send_from', 'value' => ''],
            ['key'      => 'smtp_mail_send_from_name', 'value' => ''],
            ['key'      => 'smtp_mail_host', 'value' => ''],
            ['key'      => 'smtp_mail_user', 'value' => ''],
            ['key'      => 'smtp_mail_password', 'value' => ''],
            ['key'      => 'smtp_mail_port', 'value' => ''],
            ['key'      => 'file_document_max_size', 'value' => '10'],
            ['key'      => 'file_document_extensions_allowed', 'value' => 'pdf,xlsx,docx,doc'],
            ['key'      => 'file_image_max_size', 'value' => '10'],
            ['key'      => 'file_image_extensions_allowed', 'value' => 'jpg,png,jpeg,JPG,JPEG,PNG'],
            ['key'      => 'third_party_wp_11za_authtoken', 'value' => ''],
            ['key'      => 'third_party_wp_11za_origin_website', 'value' => ''],
            ['key'      => 'test_mobile', 'value' => ''],
            ['key'      => 'test_email', 'value' => '']
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
        AppSettingsModel::truncate();
    }
};
