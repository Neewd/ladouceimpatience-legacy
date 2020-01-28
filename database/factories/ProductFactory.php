<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Brand;
use App\Model;
use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {

    return [
        'name' => $faker->company,
        'description' => $faker->realText(150),
        'advices' => $faker->realText(150, 3),
        'caracteristics' => $faker->realText(150, 3),
        'available_stock' => $faker->randomNumber(2),
        'range' => $faker->numberBetween(1,3),
        'brand_id' => $faker->randomElement(Brand::pluck('id'))
    ];
});
