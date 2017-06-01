<?php

namespace App\Modules\Electrons\Users;

use Carbon\Carbon;
use App\Modules\Models\Role;
use App\Modules\Nucleons\Service;

class RoleService extends Service
{
    /**
     * Create all required roles.
     * Caution: This method should only be invoked once on a seeder!
     *
     * @return void
     */
    public function createAllRequired()
    {
        $now = Carbon::now()->toDateTimeString();

        Role::insert([
            ['name' => 'Administrator', 'created_at' => $now], 
            ['name' => 'Entrant', 'created_at' => $now],
            ['name' => 'Committee', 'created_at' => $now],
        ]);
    }
}
