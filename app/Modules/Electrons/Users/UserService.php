<?php

namespace App\Modules\Electrons\Users;

use App\User;
use App\Modules\Nucleons\Service;

class UserService extends Service
{
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
     * Attributes that are sortable for query (aside from ID and timestamps).
     *
     * @var array
     */
    protected $sortable = [
        'email',
    ];

    /**
     * Attributes that are comparable for query (aside from ID and timestamps).
     *
     * @var array
     */
    protected $comparable = [
        'email', 'role_id',
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
    ];

    /**
     * The main model for the service.
     *
     * @var User
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

        return $user;
    }

    /**
     * Update a user.
     *
     * @param  User   $user
     * @param  array  $data
     * @return $this
     */
    public function update(User $user, array $data)
    {
        $cleaned = $this->cryptPassword($this->clean($data));

        foreach ($cleaned as $field => $value) {
            $user->{$field} = $value;
        }

        $user->save();

        return $this;
    }

    /**
     * Load mandatory relationships of the user.
     *
     * @param  User  $user
     * @return this
     */
    public function loadRelationships(User $user)
    {
        $user->load('role', 'profile');

        if ($user->isEntrant()) {
            $user->load('entry');
        }

        return $this;
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
