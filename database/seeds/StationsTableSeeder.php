<?php

use App\Station;
use Illuminate\Database\Seeder;

class StationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate existing records to start from scratch.
        Station::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            $station = new Station([
                'name' => $faker->company,
                'isOpen' => rand(0,1),
                'latitude' => $faker->latitude,
                'longitude' => $faker->longitude,
            ]);
            $station->city()->associate(\App\City::inRandomOrder()->first());
            $station->save();
        }
    }
}
