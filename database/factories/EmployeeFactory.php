<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Employee;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'sns' => $faker->name(),
        'post_id' => rand(1,7),
        'degree_id' => rand(1,2)
    ];
});
