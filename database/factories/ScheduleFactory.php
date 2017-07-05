<?php

/*
|--------------------------------------------------------------------------
| Schedule Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Modules\Models\Schedule::class, function (Faker\Generator $faker) {
    return [
        'activity_id' => function () {
            return factory(App\Modules\Models\Activity::class)->create()->id;
        },
        'description' => $faker->text(191),
        'held_at' => $faker->date('Y-m-d H:i:s'),
    ];
});
