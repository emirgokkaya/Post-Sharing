<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\News::class, function (Faker $faker) {
    $title = $faker->title;
    return [
        'title' => $title,
        'image' => asset('assets/images/blog/1.jpg'),
        'resize_image' => asset('assets/images/blog/1.jpg'),
        'summary' => $faker->text,
        'content' => $faker->text,
        'state' => random_int(0, 1),
        'block' => random_int(0, 1),
        'slug' => \Illuminate\Support\Str::slug($title),
        'user_id' => 1,
        'category_id' => random_int(1, 5)
    ];
});
