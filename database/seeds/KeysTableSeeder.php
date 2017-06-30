<?php

use Illuminate\Database\Seeder;
use App\Modules\Electrons\Keys\KeyService;

class KeysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param  KeyService  $keys
     * @return void
     */
    public function run(KeyService $keys)
    {
        $keys->createAllRequired();
    }
}
