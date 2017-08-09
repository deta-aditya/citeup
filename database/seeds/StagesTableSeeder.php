<?php

use Illuminate\Database\Seeder;
use App\Modules\Electrons\Stages\StageService;

class StagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param  StageService  $service
     * @return void
     */
    public function run(StageService $service)
    {
        $service->required();
    }
}
