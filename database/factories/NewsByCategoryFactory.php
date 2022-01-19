<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\NewsByCategory::class, function (Faker $faker) {
    $name = $faker->city;
    return [
        'name' => $name,
        'slug' => \Illuminate\Support\Str::slug($name),
    ];
});
