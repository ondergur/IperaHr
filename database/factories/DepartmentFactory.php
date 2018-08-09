<?php

use Faker\Generator as Faker;

$factory->define(App\Department::class, function (Faker $faker) {
    return [
        'branch_id' => $faker->numberBetween($min = 1, $max = 200),
        'name' => $faker->unique()->streetName,
    ];
});
