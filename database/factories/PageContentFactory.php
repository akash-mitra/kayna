<?php

use Faker\Generator as Faker;

$factory->define(App\PageContent::class, function (Faker $faker) {
    return [
        'body' => '<p>' . $faker->paragraph(10, true) . '</p>'
            . '<h3>' . $faker->sentence(10, true) . '</h3>'
            . '<p>' . $faker->paragraph(15, true) . '</p>'
            . '<h3>' . $faker->sentence(10, true) . '</h3>'
            . '<p>' . $faker->paragraph(15, true) . '</p>'
            . '<h3>' . $faker->sentence(10, true) . '</h3>'
            . '<p>' . $faker->paragraph(10, true) . '</p>' 
    ];
});
