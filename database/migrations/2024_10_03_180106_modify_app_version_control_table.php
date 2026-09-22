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
        Schema::table('_app_version_control', function (Blueprint $table) {
            $table->enum('app_type', ['investor', 'distributer', 'startup', 'admin'])->after('id');
            $table->string('title')->nullable()->after('force_update');
            $table->text('description')->nullable()->after('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('_app_version_control', function (Blueprint $table) {
            $table->dropColumn('app_type');
            $table->dropColumn('title');
            $table->dropColumn('description');
        });
    }
};
