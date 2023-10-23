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
        $this->call('PermissionsTableSeeder');
        $this->call('RolesTableSeeder');
        $this->call('UserTableSeeder');
        $this->call('AssetTypeTableSeeder');
        $this->call('LocationsTableSeeder');
        $this->call('OrderStatusSeeder');
        $this->call('ReceivingStatusTableSeeder');
        $this->call('StatusTableSeeder');
        // \App\Models\User::factory(10)->create();
    }
}
