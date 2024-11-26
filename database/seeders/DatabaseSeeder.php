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

        // routes

        DB::table('routes')->insert([
            'bus_id' => 1,
            'initial_stop_departure_time' => '2001-02-16 09:00:00',
            'final_stop_departure_time' => '2001-02-16 14:00:00'
        ]);

        DB::table('routes')->insert([
            'bus_id' => 2,
            'initial_stop_departure_time' => '2001-02-16 10:00:00',
            'final_stop_departure_time' => '2001-02-16 15:00:00'
        ]);

        DB::table('routes')->insert([
            'bus_id' => 3,
            'initial_stop_departure_time' => '2001-02-16 08:30:00',
            'final_stop_departure_time' => '2001-02-16 16:15:00'
        ]);

        // buses

        DB::table('buses')->insert([
            'number' => 12
        ]);

        DB::table('buses')->insert([
            'number' => 46
        ]);

        DB::table('buses')->insert([
            'number' => 7
        ]);

        // stops

        DB::table('stops')->insert([
            'name' => 'ул.Попова',
            'stops_order' => 0,
            'route_id' => 1
        ]);

        DB::table('stops')->insert([
            'name' => 'Аэропорт',
            'stops_order' => 1,
            'route_id' => 1
        ]);

        DB::table('stops')->insert([
            'name' => 'Вокзал',
            'stops_order' => 2,
            'route_id' => 1
        ]);

        DB::table('stops')->insert([
            'name' => 'ул.Колчака',
            'stops_order' => 3,
            'route_id' => 1
        ]);

        DB::table('stops')->insert([
            'name' => 'ул.Демидова',
            'stops_order' => 4,
            'route_id' => 1
        ]);

        DB::table('stops')->insert([
            'name' => 'ул.Петрова',
            'stops_order' => 5,
            'route_id' => 1
        ]);

        DB::table('stops')->insert([
            'name' => 'Больница №7',
            'stops_order' => 6,
            'route_id' => 1
        ]);
        
        // route 2

        DB::table('stops')->insert([
            'name' => 'ул.Попова',
            'stops_order' => 0,
            'route_id' => 2
        ]);

        DB::table('stops')->insert([
            'name' => 'ВДНХ',
            'stops_order' => 1,
            'route_id' => 2
        ]);

        DB::table('stops')->insert([
            'name' => 'ул.Галицина',
            'stops_order' => 2,
            'route_id' => 2
        ]);

        DB::table('stops')->insert([
            'name' => 'Рынок',
            'stops_order' => 3,
            'route_id' => 2
        ]);

        DB::table('stops')->insert([
            'name' => 'ул.Павлова',
            'stops_order' => 4,
            'route_id' => 2
        ]);

        DB::table('stops')->insert([
            'name' => 'ул.Артемьева',
            'stops_order' => 5,
            'route_id' => 2
        ]);

        DB::table('stops')->insert([
            'name' => 'ул.Бора',
            'stops_order' => 6,
            'route_id' => 2
        ]);

        // route 3

        DB::table('stops')->insert([
            'name' => 'Больница №2',
            'stops_order' => 0,
            'route_id' => 3
        ]);

        DB::table('stops')->insert([
            'name' => 'ул.Герцена',
            'stops_order' => 1,
            'route_id' => 3
        ]);

        DB::table('stops')->insert([
            'name' => 'ул.Победы',
            'stops_order' => 2,
            'route_id' => 3
        ]);

        DB::table('stops')->insert([
            'name' => 'Площадь Мужества',
            'stops_order' => 3,
            'route_id' => 3
        ]);

        DB::table('stops')->insert([
            'name' => 'ул.Леонтьева',
            'stops_order' => 4,
            'route_id' => 3
        ]);

        DB::table('stops')->insert([
            'name' => 'Водоканал',
            'stops_order' => 5,
            'route_id' => 3
        ]);
    }
}
