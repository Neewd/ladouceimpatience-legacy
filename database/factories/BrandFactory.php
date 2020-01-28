<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Brand;
use Faker\Generator as Faker;

$factory->define(Brand::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'picture_url' => $faker->imageUrl(150, 50),
        'description' => $faker->realText(300, 4)
    ];
});
