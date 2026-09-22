<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    public function up(): void
    {
        $permission = Permission::firstOrCreate(
            ['name' => 'ai_autowork', 'guard_name' => 'admin']
        );

        $roles = Role::where('guard_name', 'admin')
            ->whereHas('permissions', function ($q) {
                $q->where('name', 'company')->where('guard_name', 'admin');
            })
            ->get();

        foreach ($roles as $role) {
            if (!$role->hasPermissionTo($permission)) {
                $role->givePermissionTo($permission);
            }
        }
    }

    public function down(): void
    {
        $permission = Permission::where('name', 'ai_autowork')->where('guard_name', 'admin')->first();
        if ($permission) {
            foreach (Role::where('guard_name', 'admin')->get() as $role) {
                if ($role->hasPermissionTo($permission)) {
                    $role->revokePermissionTo($permission);
                }
            }
            $permission->delete();
        }
    }
};
