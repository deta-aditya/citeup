<?php

namespace App\Modules\Electrons\Users;

use App\User;
use App\Modules\Models\Role;
use App\Modules\Models\Profile;
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

        return $query->get();
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
     * Create a new user with its profile (and entry if necessary).
     *
     * @param  array  $data
     * @return User
     */
    public function createComplete(array $data)
    {
        $user = $this->create($data);

        $user = $this->makeProfile($user, $data);

        if (! $user->isEntrant()) {
            return $user;
        }

        return $user->makeEntry($user, $data); // todo
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
     * Create a profile for the user model.
     *
     * @param  User  $user
     * @param  array $data
     * @return User
     */
    public function makeProfile(User $user, array $data)
    {
        $cleaned = array_only($data, $this->getProfileModel()->getFillable());

        $user->profile()->create($cleaned);

        return $user;
    }

    /**
     * Get the profile model.
     *
     * @return Profile
     */
    public function getProfileModel()
    {
        return new Profile;
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
