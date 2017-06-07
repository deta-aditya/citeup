<?php

namespace App\Modules\Electrons\Users;

use App\User;
use App\Modules\Models\Role;
use App\Modules\Nucleons\Service;

class UserService extends Service
{
    /**
     * The default role ID.
     * Currently set to "Entrant".
     *
     * @var array
     */
    protected $defaultRole = 2;

    /**
     * Eligible attributes for new user data insertion.
     *
     * @var array
     */
    protected $pure = [
        'email', 'password',
    ];

    /**
     * Default values for query string.
     * 
     * @var array
     */
    protected $defaults = [

        // By default user data will be fetched with its profile and entry.
        'with' => ['profile', 'entry'],

    ];

    /**
     * Attributes that are selectable for query (aside from ID and timestamps).
     *
     * @var array
     */
    protected $selectable = [
        'email',
    ];

    /**
     * Relationships that are loadable for query.
     *
     * @var array
     */
    protected $loadable = [
        'profile', 'entry',
    ];

    /**
     * Data for creating starter admin user.
     *
     * @var array
     */
    protected $starterAdmin = [
        'email' => 'muhammaddetaaditya@gmail.com',
        'password' => 'rahasia',
        'role' => 1,
    ];

    /**
     * The main model for the service.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Get multiple users with conditions.
     *
     * @param  array  $params
     * @return array
     */
    public function getMultiple(array $params)
    {
        $query = $this->queryRaw($this->getModel()->query(), $params);

        // Shortcut to where=role_id:=:xxx
        if (array_has($params, 'role')) {
            $query->ofRole((int) $params['role']);
        }

        return $this->queryComplete($query);
        
    }

    /**
     * Create a new user and return it.
     *
     * @param  array  $data
     * @return User
     */
    public function create(array $data)
    {
        $cleaned = $this->cryptPassword($this->clean($data));

        $user = $this->getModel()->fill($cleaned);

        $role = Role::find(
            array_has($data, 'role') ? $data['role'] : $this->defaultRole
        );

        return $this->associateRole($user, $role);
    }

    /**
     * Create a new starter admin user and return it.
     * Caution: This method should only be invoked once on a seeder!
     *
     * @return User
     */
    public function createStarterAdmin()
    {
        return $this->create($this->starterAdmin);
    }

    /**
     * Associate role with a user and return the user.
     *
     * @param  User  $user
     * @param  Role  $role
     * @return User
     */
    public function associateRole(User $user, Role $role)
    {
        $user->role()->associate($role);

        $user->save();

        return $user;
    }

    /**
     * Crypt an array that consists of 'password' key.
     *
     * @param  array  $data
     * @return array
     */
    protected function cryptPassword(array $data) 
    {
        if (array_has($data, 'password')) {
            $data['password'] = bcrypt($data['password']);
        }

        return $data;
    }
}
