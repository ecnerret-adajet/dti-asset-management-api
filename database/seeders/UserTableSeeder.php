<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Model\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::where('name', '=', 'Admin')->first();

        if (User::where('email', '=', 'admin@admin.com')->first() === null) {
            $newUser = User::create([
                'first_name'    => 'admin',
                'last_name'    => 'system',
                'name'     => 'admin',
                'email'    => 'admin@admin.com',
                'image_path'    => 'default.png',
                'password' => bcrypt('password2023'),
            ]);

            $newUser->roles()->attach($adminRole);
        }
    }
}
