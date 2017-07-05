<?php

/*
|--------------------------------------------------------------------------
| Document Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Modules\Models\Document::class, function (Faker\Generator $faker) {
    return [
        'entry_id' => function () {
            
            $user = factory(App\User::class)->create();

            resolve('App\Modules\Electrons\Activities\EntryService')->make(
                $user, 
                factory(App\Modules\Models\Activity::class)->create()
            );

            return $user->entry->id;
        },
        'file' => $faker->text(191),
        'type' => $faker->numberBetween(0, 9),
    ];
});
