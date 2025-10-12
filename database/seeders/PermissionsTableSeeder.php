<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            // Basic permissions
            [
                'name' => 'read',
                'description' => 'read',
                'slug' => 'read',
            ],
            [
                'name' => 'create',
                'description' => 'create',
                'slug' => 'create',
            ],
            [
                'name' => 'update',
                'description' => 'update',
                'slug' => 'update',
            ],
            [
                'name' => 'delete',
                'description' => 'delete',
                'slug' => 'delete',
            ],
            
            // User permissions
            [
                'name' => 'show user',
                'description' => 'show user',
                'slug' => 'show-user',
            ],
            [
                'name' => 'create user',
                'description' => 'create user',
                'slug' => 'create-user',
            ],
            [
                'name' => 'view users',
                'description' => 'View users section',
                'slug' => 'view-users',
            ],
            [
                'name' => 'view roles',
                'description' => 'View roles section',
                'slug' => 'view-roles',
            ],
            [
                'name' => 'create role',
                'description' => 'create role',
                'slug' => 'create-role',
            ],
            [
                'name' => 'update role',
                'description' => 'update role',
                'slug' => 'update-role',
            ],
            [
                'name' => 'delete role',
                'description' => 'delete role',
                'slug' => 'delete-role',
            ],
            [
                'name' => 'view permissions',
                'description' => 'View permissions section',
                'slug' => 'view-permissions',
            ],
            
            // Settings permissions
            [
                'name' => 'settings',
                'description' => 'settings',
                'slug' => 'settings',
            ],
            
            // Orders permissions
            [
                'name' => 'orders-show',
                'description' => 'orders-show',
                'slug' => 'orders-show',
            ],
            [
                'name' => 'orders-create',
                'description' => 'orders-create',
                'slug' => 'orders-create',
            ],
            [
                'name' => 'orders-update',
                'description' => 'orders-update',
                'slug' => 'orders-update',
            ],
            [
                'name' => 'orders-delete',
                'description' => 'orders-delete',
                'slug' => 'orders-delete',
            ],
            
            // Request permissions
            [
                'name' => 'request-show',
                'description' => 'request-show',
                'slug' => 'request-show',
            ],
            [
                'name' => 'request-create',
                'description' => 'request-create',
                'slug' => 'request-create',
            ],
            [
                'name' => 'request-update',
                'description' => 'request-update',
                'slug' => 'request-update',
            ],
            [
                'name' => 'request-delete',
                'description' => 'request-delete',
                'slug' => 'request-delete',
            ],
            
            // Account permissions
            [
                'name' => 'view customers',
                'description' => 'View customers section',
                'slug' => 'view-customers',
            ],
            [
                'name' => 'view suppliers',
                'description' => 'View suppliers section',
                'slug' => 'view-suppliers',
            ],
            [
                'name' => 'create supplier',
                'description' => 'Create supplier section',
                'slug' => 'create-supplier',
            ],
            [
                'name' => 'edit supplier',
                'description' => 'Edit supplier section',
                'slug' => 'edit-supplier',
            ],
            [
                'name' => 'delete supplier',
                'description' => 'Delete supplier section',
                'slug' => 'delete-supplier',
            ],
            [
                'name' => 'create asset type',
                'description' => 'Create asset type',
                'slug' => 'create-asset-type',
            ],
            [
                'name' => 'create location',
                'description' => 'Create location',
                'slug' => 'create-location',
            ],
            [
                'name' => 'create customer',
                'description' => 'Create customer',
                'slug' => 'create-customer',
            ],
            [
                'name' => 'edit customer',
                'description' => 'Edit customer',
                'slug' => 'edit-customer',
            ],
            [
                'name' => 'delete customer',
                'description' => 'Delete customer',
                'slug' => 'delete-customer',
            ],
        ];
        
        // Check if each permission exists before inserting
        foreach ($permissions as $permission) {
            $exists = DB::table('permissions')
                ->where('slug', $permission['slug'])
                ->exists();
                
            if (!$exists) {
                DB::table('permissions')->insert($permission);
            }
        }
    }
}
