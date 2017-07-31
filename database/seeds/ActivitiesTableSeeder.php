<?php

use Illuminate\Database\Seeder;
use App\Modules\Electrons\Activities\ActivityService;

class ActivitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param  ActivityService  $activities
     * @return void
     */
    public function run(ActivityService $activities)
    {
        $activities->createAllRequired();
    }
}
