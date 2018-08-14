<?php

use Faker\Generator as Faker;

$factory->define(App\Employee::class, function (Faker $faker) {
    return [
        'department_id' => $faker->numberBetween($min = 1, $max =500),
        'firstName' => $faker->firstName,
        'lastName' => $faker->lastName,
        'email' => $faker->unique()->email,
        'phone' => $faker->unique()->phoneNumber,
    ];
});
