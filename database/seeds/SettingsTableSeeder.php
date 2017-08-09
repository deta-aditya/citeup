<?php

use Illuminate\Database\Seeder;
use App\Modules\Electrons\Settings\Settings;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param  Settings  $settings
     * @return void
     */
    public function run(Settings $settings)
    {
        $settings->required();
    }
}
