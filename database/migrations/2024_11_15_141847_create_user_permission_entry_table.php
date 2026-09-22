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
        Permission::create(['name' => 'portfolio', 'guard_name' => 'admin']);
        Permission::create(['name' => 'primary transaction', 'guard_name' => 'admin']);
        Permission::create(['name' => 'secondary transaction', 'guard_name' => 'admin']);
        Permission::create(['name' => 'pre ipo transaction', 'guard_name' => 'admin']);
        Permission::create(['name' => 'investor', 'guard_name' => 'admin']);
        Permission::create(['name' => 'partner', 'guard_name' => 'admin']);
        Permission::create(['name' => 'startup', 'guard_name' => 'admin']);
        Permission::create(['name' => 'company', 'guard_name' => 'admin']);
        Permission::create(['name' => 'seller', 'guard_name' => 'admin']);
        Permission::create(['name' => 'cms reports', 'guard_name' => 'admin']);
        Permission::create(['name' => 'sm updates news', 'guard_name' => 'admin']);
        Permission::create(['name' => 'sm mis', 'guard_name' => 'admin']);
        Permission::create(['name' => 'sm mgt14', 'guard_name' => 'admin']);
        Permission::create(['name' => 'sm offer request', 'guard_name' => 'admin']);
        Permission::create(['name' => 'sm live pitch', 'guard_name' => 'admin']);
        Permission::create(['name' => 'sm pas3', 'guard_name' => 'admin']);
        Permission::create(['name' => 'manual kyc requests', 'guard_name' => 'admin']);
        Permission::create(['name' => 'primary payment receipt', 'guard_name' => 'admin']);
        Permission::create(['name' => 'masters', 'guard_name' => 'admin']);
        Permission::create(['name' => 'cms management', 'guard_name' => 'admin']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
