<?php

namespace App\Modules\Electrons\Users;

use Carbon\Carbon;
use App\User;
use App\Modules\Models\Role;
use App\Modules\Nucleons\Service;

class RoleService extends Service
{
    /**
     * The ID of administrator role record.
     */
    const ROLE_ADMINISTRATOR = 1;

    /**
     * The ID of entrant role record.
     */
    const ROLE_ENTRANT = 2;

    /**
     * The ID of committee role record.
     */
    const ROLE_COMMITTEE = 3;

    /**
     * The main model for the service.
     *
     * @var User
     */
    protected $model = Role::class;

    /**
     * Create all required roles.
     * Caution: This method should only be invoked once on a seeder!
     *
     * @return this
     */
    public function createAllRequired()
    {
        $now = Carbon::now()->toDateTimeString();

        Role::insert([
            ['name' => 'Administrator', 'created_at' => $now], 
            ['name' => 'Entrant', 'created_at' => $now],
            ['name' => 'Committee', 'created_at' => $now],
        ]);

        return $this;
    }

    /**
     * Associate role with a user and return the user.
     *
     * @param  User      $user
     * @param  Role|int  $role
     * @return this
     */
    public function associate(User $user, $role)
    {
        if (! $role instanceof Role) {
            $role = Role::find($role);
        }

        if ($role->id === $user->role->id) {
            return $this;
        }

        $user->role()->associate($role);

        $user->save();

        return $this;
    }
}
