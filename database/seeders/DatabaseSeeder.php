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
            'initial_stop_departure_time' => '2001-02-16 09:00:00',
            'final_stop_departure_time' => '2001-02-16 14:00:00'
        ]);

        DB::table('routes')->insert([
            'initial_stop_departure_time' => '2001-02-16 10:00:00',
            'final_stop_departure_time' => '2001-02-16 15:00:00'
        ]);

        DB::table('routes')->insert([
            'initial_stop_departure_time' => '2001-02-16 10:00:00',
            'final_stop_departure_time' => '2001-02-16 15:00:00'
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

        // route 1 seq

        DB::table('route_stop_sequences')->insert([
            'route_id' => 1,
            'stop_id' => 1,
            'sequence' => 0
        ]);


        DB::table('route_stop_sequences')->insert([
            'route_id' => 1,
            'stop_id' => 2,
            'sequence' => 1
        ]);

        DB::table('route_stop_sequences')->insert([
            'route_id' => 1,
            'stop_id' => 3,
            'sequence' => 2
        ]);

        DB::table('route_stop_sequences')->insert([
            'route_id' => 1,
            'stop_id' => 4,
            'sequence' => 3
        ]);

        DB::table('route_stop_sequences')->insert([
            'route_id' => 1,
            'stop_id' => 5,
            'sequence' => 4
        ]);

        DB::table('route_stop_sequences')->insert([
            'route_id' => 1,
            'stop_id' => 6,
            'sequence' => 5
        ]);

        DB::table('route_stop_sequences')->insert([
            'route_id' => 1,
            'stop_id' => 7,
            'sequence' => 6
        ]);

        // route 2 seq

        DB::table('route_stop_sequences')->insert([
            'route_id' => 2,
            'stop_id' => 1,
            'sequence' => 2
        ]);


        DB::table('route_stop_sequences')->insert([
            'route_id' => 2,
            'stop_id' => 4,
            'sequence' => 3
        ]);

        DB::table('route_stop_sequences')->insert([
            'route_id' => 2,
            'stop_id' => 8,
            'sequence' => 0
        ]);

        DB::table('route_stop_sequences')->insert([
            'route_id' => 2,
            'stop_id' => 9,
            'sequence' => 1
        ]);

        DB::table('route_stop_sequences')->insert([
            'route_id' => 2,
            'stop_id' => 10,
            'sequence' => 4
        ]);

        DB::table('route_stop_sequences')->insert([
            'route_id' => 2,
            'stop_id' => 11,
            'sequence' => 5
        ]);

        DB::table('route_stop_sequences')->insert([
            'route_id' => 2,
            'stop_id' => 12,
            'sequence' => 6
        ]);

        // route 3 seq

        DB::table('route_stop_sequences')->insert([
            'route_id' => 3,
            'stop_id' => 1,
            'sequence' => 0
        ]);


        DB::table('route_stop_sequences')->insert([
            'route_id' => 3,
            'stop_id' => 13,
            'sequence' => 1
        ]);

        DB::table('route_stop_sequences')->insert([
            'route_id' => 3,
            'stop_id' => 14,
            'sequence' => 2
        ]);

        DB::table('route_stop_sequences')->insert([
            'route_id' => 3,
            'stop_id' => 15,
            'sequence' => 3
        ]);

        DB::table('route_stop_sequences')->insert([
            'route_id' => 3,
            'stop_id' => 16,
            'sequence' => 4
        ]);

        DB::table('route_stop_sequences')->insert([
            'route_id' => 3,
            'stop_id' => 17,
            'sequence' => 5
        ]);

        DB::table('route_stop_sequences')->insert([
            'route_id' => 3,
            'stop_id' => 18,
            'sequence' => 6
        ]);


        // stops

        DB::table('stops')->insert([
            'name' => 'ул.Попова'
        ]);

        DB::table('stops')->insert([
            'name' => 'Аэропорт'
        ]);

        DB::table('stops')->insert([
            'name' => 'Вокзал'
        ]);

        DB::table('stops')->insert([
            'name' => 'ул.Колчака'
        ]);

        DB::table('stops')->insert([
            'name' => 'ул.Демидовича'
        ]);

        DB::table('stops')->insert([
            'name' => 'ул.Петрова'
        ]);

        DB::table('stops')->insert([
            'name' => 'Больница №7'
        ]);
        
        // route 2

        DB::table('stops')->insert([
            'name' => 'ул.Знамени'
        ]);

        DB::table('stops')->insert([
            'name' => 'ВДНХ'
        ]);

        DB::table('stops')->insert([
            'name' => 'Рынок'
        ]);

        DB::table('stops')->insert([
            'name' => 'ул.Павлова'
        ]);

        DB::table('stops')->insert([
            'name' => 'ул.Бора'
        ]);

        // route 3

        DB::table('stops')->insert([
            'name' => 'ул.Герцена'
        ]);

        DB::table('stops')->insert([
            'name' => 'ул.Победы'
        ]);

        DB::table('stops')->insert([
            'name' => 'Площадь Мужества'
        ]);

        DB::table('stops')->insert([
            'name' => 'ул.Леонтьева'
        ]);

        DB::table('stops')->insert([
            'name' => 'Водоканал'
        ]);

        DB::table('stops')->insert([
            'name' => 'Аптека'
        ]);
    }
}
