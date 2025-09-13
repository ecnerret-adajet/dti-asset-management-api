<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReceivingStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'name' => 'To Order',
                'slug' => 'to-order',
            ],
            [
                'name' => 'Ordered',
                'slug' => 'ordered',
            ],
            [
                'name' => 'In Transit',
                'slug' => 'in-transit',
            ],
            [
                'name' => 'Added',
                'slug' => 'added',
            ],
            [
                'name' => 'Cancelled',
                'slug' => 'cancelled',
            ],
        ];

        foreach ($statuses as $status) {
            // Check if the name or slug already exists
            $exists = DB::table('receiving_statuses')
                ->where('name', $status['name'])
                ->orWhere('slug', $status['slug'])
                ->exists();

            // Only insert if it doesn't exist
            if (!$exists) {
                DB::table('receiving_statuses')->insert([
                    'name' => $status['name'],
                    'slug' => $status['slug'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
