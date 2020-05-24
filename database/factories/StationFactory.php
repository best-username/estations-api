<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\City;
use App\Station;
use Faker\Generator as Faker;

$factory->define(Station::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'isOpen' => rand(0,1),
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
        'city_id' => City::inRandomOrder()->first()->id,
    ];
});
