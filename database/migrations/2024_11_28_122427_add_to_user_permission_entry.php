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
        Schema::table('user_permission_entry', function (Blueprint $table) {
            Permission::create(['name' => 'manual secondary market', 'guard_name' => 'admin']);
            Permission::create(['name' => 'manual preipo transaction', 'guard_name' => 'admin']);
            Permission::create(['name' => 'manual primary transaction', 'guard_name' => 'admin']);
            Permission::create(['name' => 'manual secondary transaction', 'guard_name' => 'admin']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_permission_entry', function (Blueprint $table) {
            //
        });
    }
};
