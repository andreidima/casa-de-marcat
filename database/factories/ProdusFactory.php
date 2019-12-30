<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Produs;
use Faker\Generator as Faker;

$factory->define(Produs::class, function (Faker $faker) {
    
    static $number = 100000;
    $pret_de_achizitie = $faker->randomFloat($nbMaxDecimals = 2, $min = 10, $max = 500);

    return [
        'nume' => $faker->colorName,
        'categorie_produs_id' => $faker->numberBetween(1, 4),
        'pret_de_achizitie' => $pret_de_achizitie,
        'pret' => $pret_de_achizitie * 1.2,
        'cantitate' => $faker->numberBetween(5 ,100),
        // 'cod_de_bare' => $faker->numberBetween(100000000000, 999999999999),
        'cod_de_bare' => $number++,
        'localizare' => $faker->bothify('Raft ##??'), // 'Raft 42jz'
        'descriere' => $faker->sentence($nbWords = 6, $variableNbWords = true),
    ];
});
