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
        Schema::table('investor_register_request', function (Blueprint $table) {
            $table->boolean('is_startup')->default(0)->after('notes');
            $table->text('description')->nullable()->after('is_startup')->comment('Description of the startup');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investor_register_request', function (Blueprint $table) {
            $table->dropColumn(['is_startup', 'description']);
        });
    }
};
