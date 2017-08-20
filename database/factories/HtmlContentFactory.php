<?php

/*
|--------------------------------------------------------------------------
| Html Content Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Modules\Models\HtmlContent::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->text(191),
        'content' => $faker->paragraphs(3, true),
    ];
});
