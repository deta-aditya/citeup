<?php

/*
|--------------------------------------------------------------------------
| Activity Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Modules\Models\Activity::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->words(2, true),
        'description' => $faker->paragraph(),
        'short_description' => $faker->text(191),
        'icon' => 'images/default.jpg',
    ];
});
