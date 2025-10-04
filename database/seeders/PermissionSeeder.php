<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\PermissionCategory;
use App\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Permission Categories
        $categories = [
            ['name' => 'Asset Management', 'slug' => 'asset-management', 'description' => 'Permissions related to asset management', 'order' => 1],
            ['name' => 'Inventory Management', 'slug' => 'inventory-management', 'description' => 'Permissions for inventory operations', 'order' => 2],
            ['name' => 'Order Management', 'slug' => 'order-management', 'description' => 'Permissions for order processing', 'order' => 3],
            ['name' => 'Request Management', 'slug' => 'request-management', 'description' => 'Permissions for receiving requests', 'order' => 4],
            ['name' => 'User Management', 'slug' => 'user-management', 'description' => 'Permissions for user and role management', 'order' => 5],
            ['name' => 'Account Management', 'slug' => 'account-management', 'description' => 'Permissions for customer and supplier management', 'order' => 6],
            ['name' => 'Reports', 'slug' => 'reports', 'description' => 'Permissions for reporting and analytics', 'order' => 7],
        ];

        foreach ($categories as $category) {
            PermissionCategory::create($category);
        }

        // Define all permissions with categories
        $permissions = [
            // Asset Management Permissions
            ['name' => 'View Assets', 'slug' => 'view-assets', 'category' => 'asset-management'],
            ['name' => 'Create Assets', 'slug' => 'create-assets', 'category' => 'asset-management'],
            ['name' => 'Edit Assets', 'slug' => 'edit-assets', 'category' => 'asset-management'],
            ['name' => 'Delete Assets', 'slug' => 'delete-assets', 'category' => 'asset-management'],
            ['name' => 'View Asset Details', 'slug' => 'view-asset-details', 'category' => 'asset-management'],
            ['name' => 'Manage Asset Images', 'slug' => 'manage-asset-images', 'category' => 'asset-management'],
            ['name' => 'Change Asset Location', 'slug' => 'change-asset-location', 'category' => 'asset-management'],

            // Inventory Management Permissions
            ['name' => 'View Inventory', 'slug' => 'view-inventory', 'category' => 'inventory-management'],
            ['name' => 'Update Inventory', 'slug' => 'update-inventory', 'category' => 'inventory-management'],
            ['name' => 'Add to Inventory', 'slug' => 'add-to-inventory', 'category' => 'inventory-management'],
            ['name' => 'Stock Out', 'slug' => 'stock-out', 'category' => 'inventory-management'],
            ['name' => 'View Stock Cards', 'slug' => 'view-stock-cards', 'category' => 'inventory-management'],

            // Order Management Permissions
            ['name' => 'View Orders', 'slug' => 'view-orders', 'category' => 'order-management'],
            ['name' => 'Create Orders', 'slug' => 'create-orders', 'category' => 'order-management'],
            ['name' => 'Edit Orders', 'slug' => 'edit-orders', 'category' => 'order-management'],
            ['name' => 'Delete Orders', 'slug' => 'delete-orders', 'category' => 'order-management'],
            ['name' => 'Change Order Status', 'slug' => 'change-order-status', 'category' => 'order-management'],
            ['name' => 'View Order Details', 'slug' => 'view-order-details', 'category' => 'order-management'],
            ['name' => 'Mark Order as Delivered', 'slug' => 'mark-order-delivered', 'category' => 'order-management'],
            ['name' => 'Mark Order as Failed', 'slug' => 'mark-order-failed', 'category' => 'order-management'],

            // Request Management Permissions
            ['name' => 'View Requests', 'slug' => 'view-requests', 'category' => 'request-management'],
            ['name' => 'Create Requests', 'slug' => 'create-requests', 'category' => 'request-management'],
            ['name' => 'Edit Requests', 'slug' => 'edit-requests', 'category' => 'request-management'],
            ['name' => 'Delete Requests', 'slug' => 'delete-requests', 'category' => 'request-management'],
            ['name' => 'Change Request Status', 'slug' => 'change-request-status', 'category' => 'request-management'],
            ['name' => 'Add Request to Inventory', 'slug' => 'add-request-to-inventory', 'category' => 'request-management'],

            // User Management Permissions
            ['name' => 'View Users', 'slug' => 'view-users', 'category' => 'user-management'],
            ['name' => 'Create Users', 'slug' => 'create-users', 'category' => 'user-management'],
            ['name' => 'Edit Users', 'slug' => 'edit-users', 'category' => 'user-management'],
            ['name' => 'Delete Users', 'slug' => 'delete-users', 'category' => 'user-management'],
            ['name' => 'View Roles', 'slug' => 'view-roles', 'category' => 'user-management'],
            ['name' => 'Create Roles', 'slug' => 'create-roles', 'category' => 'user-management'],
            ['name' => 'Edit Roles', 'slug' => 'edit-roles', 'category' => 'user-management'],
            ['name' => 'Delete Roles', 'slug' => 'delete-roles', 'category' => 'user-management'],
            ['name' => 'Assign Permissions', 'slug' => 'assign-permissions', 'category' => 'user-management'],

            // Account Management Permissions
            ['name' => 'View Customers', 'slug' => 'view-customers', 'category' => 'account-management'],
            ['name' => 'Create Customers', 'slug' => 'create-customers', 'category' => 'account-management'],
            ['name' => 'Edit Customers', 'slug' => 'edit-customers', 'category' => 'account-management'],
            ['name' => 'Delete Customers', 'slug' => 'delete-customers', 'category' => 'account-management'],
            ['name' => 'View Suppliers', 'slug' => 'view-suppliers', 'category' => 'account-management'],
            ['name' => 'Create Suppliers', 'slug' => 'create-suppliers', 'category' => 'account-management'],
            ['name' => 'Edit Suppliers', 'slug' => 'edit-suppliers', 'category' => 'account-management'],
            ['name' => 'Delete Suppliers', 'slug' => 'delete-suppliers', 'category' => 'account-management'],

            // Reports Permissions
            ['name' => 'View Reports', 'slug' => 'view-reports', 'category' => 'reports'],
            ['name' => 'Generate Reports', 'slug' => 'generate-reports', 'category' => 'reports'],
            ['name' => 'Export Reports', 'slug' => 'export-reports', 'category' => 'reports'],
            ['name' => 'View Inventory Alerts', 'slug' => 'view-inventory-alerts', 'category' => 'reports'],
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            $category = PermissionCategory::where('slug', $permission['category'])->first();

            Permission::create([
                'name' => $permission['name'],
                'slug' => $permission['slug'],
                'category_id' => $category->id,
            ]);
        }

        // Create default roles
        $adminRole = Role::firstOrCreate(
            ['name' => 'Super Admin'],
            ['level' => 1]
        );

        $managerRole = Role::firstOrCreate(
            ['name' => 'Manager'],
            ['level' => 2]
        );

        $userRole = Role::firstOrCreate(
            ['name' => 'User'],
            ['level' => 3]
        );

        $viewerRole = Role::firstOrCreate(
            ['name' => 'Viewer'],
            ['level' => 4]
        );

        // Assign all permissions to Super Admin
        $adminRole->permissions()->sync(Permission::all());

        // Assign limited permissions to Manager
        $managerPermissions = Permission::whereIn('slug', [
            'view-assets', 'create-assets', 'edit-assets', 'view-asset-details', 'manage-asset-images',
            'view-inventory', 'update-inventory', 'add-to-inventory',
            'view-orders', 'create-orders', 'edit-orders', 'change-order-status', 'view-order-details',
            'view-requests', 'create-requests', 'edit-requests', 'change-request-status',
            'view-customers', 'create-customers', 'edit-customers',
            'view-suppliers', 'create-suppliers', 'edit-suppliers',
            'view-reports', 'generate-reports', 'export-reports',
        ])->pluck('id');
        $managerRole->permissions()->sync($managerPermissions);

        // Assign basic permissions to User
        $userPermissions = Permission::whereIn('slug', [
            'view-assets', 'view-asset-details',
            'view-inventory',
            'view-orders', 'create-orders', 'view-order-details',
            'view-requests', 'create-requests',
            'view-customers',
            'view-suppliers',
        ])->pluck('id');
        $userRole->permissions()->sync($userPermissions);

        // Assign view-only permissions to Viewer
        $viewerPermissions = Permission::whereIn('slug', [
            'view-assets', 'view-asset-details',
            'view-inventory',
            'view-orders', 'view-order-details',
            'view-requests',
            'view-customers',
            'view-suppliers',
            'view-reports',
        ])->pluck('id');
        $viewerRole->permissions()->sync($viewerPermissions);
    }
}
