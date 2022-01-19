<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Slider::class, function (Faker $faker) {
    $title = $faker->lastName;
    return [
        'title' => $title,
        'image' => asset('assets/images/blog/1.jpg'),
        'resize_image' => asset('assets/images/blog/1.jpg'),
        'state' => random_int(0, 1),
        'description' => $faker->text,
        'slug' => \Illuminate\Support\Str::slug($title),
        'user_id' => 1
    ];
});
