<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            UserTableSeeder::class,
            AssetTypeTableSeeder::class,
            LocationsTableSeeder::class,
            OrderStatusSeeder::class,
            ReceivingStatusTableSeeder::class,
            StatusTableSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
