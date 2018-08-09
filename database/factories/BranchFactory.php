<?php

use Faker\Generator as Faker;

$factory->define(App\Branch::class, function (Faker $faker) {
    return [
        'company_id' => $faker->numberBetween($min = 1, $max =50),
        'name' => $faker->unique()->city,
        'address' => $faker->address,
    ];
});
