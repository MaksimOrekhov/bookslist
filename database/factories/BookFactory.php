<?php

use Faker\Generator as Faker;

$factory->define(App\Book::class, function (Faker $faker) {
    return [
        'author' => $faker->text(20),
        'name' => $faker->text(100),
        'page_number' => $faker->text(10)
    ];
});
