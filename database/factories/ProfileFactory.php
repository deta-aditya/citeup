<?php

/*
|--------------------------------------------------------------------------
| Profile Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Modules\Models\Profile::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'address' => $faker->address,
        'school' => $faker->company,
        'city' => $faker->city,
        'photo' => 'storage/images/default.jpg',
        'phone' => $faker->phoneNumber,
        'section' => $faker->jobTitle,
    ];
});
