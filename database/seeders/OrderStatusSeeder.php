<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use DB;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $order_statuses = [
            [
                'name' => 'Pending',
                'slug' => 'pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'In-Transit',
                'slug' => 'in-transit',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Delivered',
                'slug' => 'delivered',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Failed',
                'slug' => 'failed',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Return',
                'slug' => 'return',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]; 

        // Check if each permission exists before inserting
        foreach ($order_statuses as $order_status) {
            $exists = DB::table('order_statuses')
                ->where('slug', $order_status['slug'])
                ->exists();
                
            if (!$exists) {
                DB::table('order_statuses')->insert($order_status);
            }
        }
    }
}
