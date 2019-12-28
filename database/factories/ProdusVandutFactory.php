<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProdusVandut;
use Faker\Generator as Faker;

$factory->define(ProdusVandut::class, function (Faker $faker) {
    return [
        'produs_id' => $faker->numberBetween(1, 50),
        'cantitate' => $faker->numberBetween(1, 3),
        'pret' => $faker->randomFloat($nbMaxDecimals = 2, $min = 10, $max = 500),

        'created_at' => $faker->dateTimeBetween($startDate = '-1 week', $endDate = '1 week', $timezone = null),
    ];
});
