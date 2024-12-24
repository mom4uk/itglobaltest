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
            'half_route_time' => 5,
            'initial_stop_departure_time' => '2001-02-16 09:00:00',
            'final_stop_departure_time' => '2001-02-16 14:00:00'
        ]);

        DB::table('routes')->insert([
            'half_route_time' => 5,
            'initial_stop_departure_time' => '2001-02-16 10:00:00',
            'final_stop_departure_time' => '2001-02-16 15:00:00'
        ]);

        DB::table('routes')->insert([
            'half_route_time' => 5,
            'initial_stop_departure_time' => '2001-02-16 10:00:00',
            'final_stop_departure_time' => '2001-02-16 15:00:00'
        ]);

        // buses

        DB::table('buses')->insert([
            'number' => 12,
            'route_id' => 1
        ]);

        DB::table('buses')->insert([
            'number' => 46,
            'route_id' => 2
        ]);

        DB::table('buses')->insert([
            'number' => 7,
            'route_id' => 3
        ]);

        // route 1 seq

        DB::table('route_stop_sequences')->insert([
            'route_id' => 1,
            'stop_id' => 1,
            'sequence_forward' => 0,
            'sequence_backward' => 5
        ]);


        DB::table('route_stop_sequences')->insert([
            'route_id' => 1,
            'stop_id' => 2,
            'sequence_forward' => 1,
            'sequence_backward' => 6
        ]);

        DB::table('route_stop_sequences')->insert([
            'route_id' => 1,
            'stop_id' => 3,
            'sequence_forward' => 2,
            'sequence_backward' => 3
        ]);

        DB::table('route_stop_sequences')->insert([
            'route_id' => 1,
            'stop_id' => 4,
            'sequence_forward' => 3,
            'sequence_backward' => 4
        ]);

        DB::table('route_stop_sequences')->insert([
            'route_id' => 1,
            'stop_id' => 5,
            'sequence_forward' => 4,
            'sequence_backward' => 1
        ]);

        DB::table('route_stop_sequences')->insert([
            'route_id' => 1,
            'stop_id' => 6,
            'sequence_forward' => 5,
            'sequence_backward' => 2
        ]);

        DB::table('route_stop_sequences')->insert([
            'route_id' => 1,
            'stop_id' => 7,
            'sequence_forward' => 6,
            'sequence_backward' => 0
        ]);

        // route 2 seq

        DB::table('route_stop_sequences')->insert([
            'route_id' => 2,
            'stop_id' => 1,
            'sequence_forward' => 2,
            'sequence_backward' => 6
        ]);


        DB::table('route_stop_sequences')->insert([
            'route_id' => 2,
            'stop_id' => 4,
            'sequence_forward' => 3,
            'sequence_backward' => 5
        ]);

        DB::table('route_stop_sequences')->insert([
            'route_id' => 2,
            'stop_id' => 8,
            'sequence_forward' => 0,
            'sequence_backward' => 4
        ]);

        DB::table('route_stop_sequences')->insert([
            'route_id' => 2,
            'stop_id' => 9,
            'sequence_forward' => 1,
            'sequence_backward' => 1
        ]);

        DB::table('route_stop_sequences')->insert([
            'route_id' => 2,
            'stop_id' => 10,
            'sequence_forward' => 4,
            'sequence_backward' => 2
        ]);

        DB::table('route_stop_sequences')->insert([
            'route_id' => 2,
            'stop_id' => 11,
            'sequence_forward' => 5,
            'sequence_backward' => 3
        ]);

        DB::table('route_stop_sequences')->insert([
            'route_id' => 2,
            'stop_id' => 12,
            'sequence_forward' => 6,
            'sequence_backward' => 0
        ]);

        // route 3 seq

        DB::table('route_stop_sequences')->insert([
            'route_id' => 3,
            'stop_id' => 1,
            'sequence_forward' => 0,
            'sequence_backward' => 6
        ]);


        DB::table('route_stop_sequences')->insert([
            'route_id' => 3,
            'stop_id' => 13,
            'sequence_forward' => 1,
            'sequence_backward' => 5
        ]);

        DB::table('route_stop_sequences')->insert([
            'route_id' => 3,
            'stop_id' => 14,
            'sequence_forward' => 2,
            'sequence_backward' => 4
        ]);

        DB::table('route_stop_sequences')->insert([
            'route_id' => 3,
            'stop_id' => 15,
            'sequence_forward' => 3,
            'sequence_backward' => 3
        ]);

        DB::table('route_stop_sequences')->insert([
            'route_id' => 3,
            'stop_id' => 16,
            'sequence_forward' => 4,
            'sequence_backward' => 1
        ]);

        DB::table('route_stop_sequences')->insert([
            'route_id' => 3,
            'stop_id' => 17,
            'sequence_forward' => 5,
            'sequence_backward' => 2
        ]);

        DB::table('route_stop_sequences')->insert([
            'route_id' => 3,
            'stop_id' => 18,
            'sequence_forward' => 6,
            'sequence_backward' => 0
        ]);


        // stops of the route 1

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
        
        // stops of the route 2

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

        // stops of the route 3

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
