<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
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
            [
                'name' => 'show user',
                'description' => 'show user',
                'slug' => 'show-user',
            ],
            [
                'name' => 'settings',
                'description' => 'settings',
                'slug' => 'settings',
            ],
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
        ]);
    }
}
