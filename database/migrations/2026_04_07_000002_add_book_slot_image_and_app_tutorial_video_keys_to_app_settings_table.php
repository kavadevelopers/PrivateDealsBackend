<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('app_settings')->insertOrIgnore([
            ['key' => 'book_slot_image', 'value' => '', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'app_tutorial_video', 'value' => '', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('app_settings')->whereIn('key', [
            'book_slot_image',
            'app_tutorial_video',
        ])->delete();
    }
};
