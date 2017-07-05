<?php

/*
|--------------------------------------------------------------------------
| Key Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Modules\Models\Key::class, function (Faker\Generator $faker) {
    
    $name = $faker->word(3, true);

    return [
        'name' => $name,
        'slug' => str_slug($name, '-'),
    ];
});
