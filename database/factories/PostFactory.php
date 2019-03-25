<?php

use App\Post;
use Faker\Generator as FakerGenerator;

$factory->define(Post::class, function (FakerGenerator $faker) {
    return [
        'name' => $faker->name,
        'content' => $faker->paragraph,
        'active'  => $faker->boolean
    ];
});