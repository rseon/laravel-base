<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    $title = $faker->sentence;

    return [
        'title' => $title,
        'content' => $faker->paragraph,
        'author_id' => function () {
            return User::all()->random()->id;
        },
        'slug' => \Illuminate\Support\Str::slug($title),
    ];
});
