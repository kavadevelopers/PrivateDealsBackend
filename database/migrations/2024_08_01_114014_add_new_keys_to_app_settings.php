<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddNewKeysToAppSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Adding new key-value pairs to the app_settings table
        DB::table('app_settings')->insert([
            ['id' => 31, 'key' => 'digio_url', 'value' => '', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 32, 'key' => 'digio_client_id', 'value' => '', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 33, 'key' => 'digio_client_secret', 'value' => '', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 34, 'key' => 'digio_webhook_hash', 'value' => '', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 35, 'key' => 'digio_kyc_id', 'value' => '', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 36, 'key' => 'digio_environment', 'value' => '', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // If needed, you can define how to reverse this migration here
        DB::table('app_settings')->whereIn('key', [
            'digio_url',
            'digio_client_id',
            'digio_client_secret',
            'digio_webhook_hash',
            'digio_kyc_id',
            'digio_environment'
        ])->delete();
    }
}
