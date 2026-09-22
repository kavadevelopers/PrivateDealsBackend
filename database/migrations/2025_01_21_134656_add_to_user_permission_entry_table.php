<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            Permission::firstOrCreate(
                ['name' => 'investor notifications', 'guard_name' => 'admin']
            );
            
            Permission::firstOrCreate(
                ['name' => 'resource billing management', 'guard_name' => 'admin']
            );
            
            Permission::firstOrCreate(
                ['name' => 'broadcast', 'guard_name' => 'admin']
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            //
        });
    }
};
