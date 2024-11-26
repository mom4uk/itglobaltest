<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('routes')->insert([
            'bus_id' => 1,
            'initial_stop_departure_time' => '9:00',
            'final_stop_departure_time' => '14:00'
        ]);

        DB::table('routes')->insert([
            'bus_id' => 2,
            'initial_stop_departure_time' => '10:00',
            'final_stop_departure_time' => '15:00'
        ]);

        DB::table('routes')->insert([
            'bus_id' => 3,
            'initial_stop_departure_time' => '8:30',
            'final_stop_departure_time' => '16:15'
        ]);
    }
}
