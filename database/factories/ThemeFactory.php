<?php

use Faker\Factory;

use App\Theme;

$factory->define(Theme::class, function () {
    $faker = Factory::create('fr_FR');
    return [
        'name' => $faker->company,
        'icon' => 'icon-test.png',
        'is_visible' => $faker->randomElement([true, false])
    ];
});
