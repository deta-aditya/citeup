<?php

/*
|--------------------------------------------------------------------------
| Answer Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Modules\Models\Answer::class, function (Faker\Generator $faker) {
    return [
        'choice_id' => function () {
            return factory(App\Modules\Models\Choice::class)->create()->id;
        },
        'attempt_id' => function () {
            return factory(App\Modules\Models\Attempt::class)->create()->id;
        },
    ];
});
