<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'name' => 'Admin',
                'description' => 'System administrator',
                'slug' => 'admin',
                'level' => 1,
            ],
            [
                'name' => 'Coordinator',
                'description' => 'System coordinator',
                'slug' => 'coordinator',
                'level' => 2,
            ],
            [
                'name' => 'Encoder',
                'description' => 'System encoder',
                'slug' => 'encoder',
                'level' => 3,
            ],
            [
                'name' => 'Personnel',
                'description' => 'Warehouse Personnel',
                'slug' => 'personnel',
                'level' => 4,
            ],
        ]);
    }
}
