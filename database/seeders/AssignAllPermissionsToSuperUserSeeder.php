<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;
use App\Models\Role;

class AssignAllPermissionsToSuperUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleId = 1; // Super user role ID

        // Check if role exists
        $role = Role::find($roleId);

        if (!$role) {
            $this->command->error("Role with ID {$roleId} not found!");
            return;
        }

        $this->command->info("Assigning all permissions to role: {$role->name}");

        // Get all permissions
        $permissions = Permission::all();

        if ($permissions->isEmpty()) {
            $this->command->warn("No permissions found in the database!");
            return;
        }

        $assigned = 0;
        $skipped = 0;

        foreach ($permissions as $permission) {
            // Check if relationship already exists
            $exists = DB::table('role_permission')
                ->where('role_id', $roleId)
                ->where('permission_id', $permission->id)
                ->exists();

            if (!$exists) {
                DB::table('role_permission')->insert([
                    'role_id' => $roleId,
                    'permission_id' => $permission->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $assigned++;
            } else {
                $skipped++;
            }
        }

        $this->command->info("✓ Assigned {$assigned} permissions to role ID {$roleId}");
        $this->command->info("✓ Skipped {$skipped} existing permission assignments");
        $this->command->info("✓ Total permissions for super user: " . ($assigned + $skipped));
    }
}
