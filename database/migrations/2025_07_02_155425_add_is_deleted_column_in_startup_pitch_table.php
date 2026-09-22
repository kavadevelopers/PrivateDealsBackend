<?php

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
        Schema::table('startup_pitch', function (Blueprint $table) {
            $table->uuid()->nullable()->after('id');
            $table->string('video_url')->nullable()->after('user_url');
            $table->boolean('is_deleted')->default(0)->after('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('startup_pitch', function (Blueprint $table) {
            $table->dropColumn(['uuid', 'is_deleted', 'video_url']);
        });
    }
};
