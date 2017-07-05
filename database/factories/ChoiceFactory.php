<?php

/*
|--------------------------------------------------------------------------
| Choice Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Modules\Models\Choice::class, function (Faker\Generator $faker) {
    return [
        'question_id' => function () {
            return factory(App\Modules\Models\Question::class)->create()->id;
        },
        'content' => $faker->text(),
        'picture' => $faker->text(191),
    ];
});
