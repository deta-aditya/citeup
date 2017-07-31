<?php

namespace App\Modules\Electrons\Users;

use App\User;
use App\Modules\Nucleons\Service;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService extends Service
{
    /**
     * Data for creating starter admin user.
     *
     * @var array
     */
    protected $starterAdmin = [
        'email' => 'admin@citeup.com',
        'password' => 'rahasia',
    ];

    /**
     * Data for creating example entrant user.
     *
     * @var array
     */
    protected $exampleEntrant = [
        'email' => 'peserta@citeup.com',
        'password' => 'rahasia',
    ];

    /**
     * Data for creating example committee user.
     *
     * @var array
     */
    protected $exampleCommittee = [
        'email' => 'panitia@citeup.com',
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
        return $this->getMultipleCustomQuery($this->getModel()->query(), $params);
    }

    /**
     * Get multiple users with custom query and conditions.
     *
     * @param  Builder  $query
     * @param  array    $params
     * @return array
     */
    public function getMultipleCustomQuery($query, array $params)
    {
        $query = $this->parseQueryString($query, $params);

        if (array_has($params, 'role')) {
            $query->ofRole((int) $params['role']);
        }

        if (array_has($params, 'name')) {
            $query->ofName($params['name']);
        } 

        if (array_has($params, 'section')) {
            $query->ofSection($params['section']);
        } 

        if (array_has($params, 'activity')) {
            $query->ofActivity((int) $params['activity']);
        } 

        if (array_has($params, 'activities')) {
            $query->ofActivities(explode($this->getDelimiter('activities'), $params['activities']));
        } 

        if (array_has($params, 'stage')) {
            $query->ofStage((int) $params['stage']);
        } 

        if (array_has($params, 'keys')) {
            $query->hasKeys(explode(config(
                'queries.users.delimiters.keys'
            ), $params['keys']));
        } 

        if (array_has($params, 'alert')) {
            $query->ofAlert((int) $params['alert']);
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

        $user = User::create($cleaned);

        return $user;
    }

    /**
     * Update a user with new data.
     *
     * @param  User   $user
     * @param  array  $data
     * @return this
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
     * Remove a user from the database.
     *
     * @param  User  $user
     * @return this
     */
    public function remove(User $user)
    {
        $user->delete();

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
            $user->load('entry', 'activity', 'alerts');
        }

        return $this;
    }

    /**
     * Determine whether any of the given values is an invalid ID.
     * 
     * @param  array  $ids
     * @return bool 
     */
    public function areInvalidId(array $ids)
    {
        try {
            $this->getModel()->query()->findOrFail($ids);
        } catch (ModelNotFoundException $e) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the email belongs to a registered user.
     * 
     * @param  string  $email
     * @return bool 
     */
    public function isAlreadyRegistered($email)
    {
        try {
            $this->getModel()->query()->where('email', $email)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return false;
        }

        return true;
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
     * Create an example entrant user.
     *
     * @return User
     */
    public function createExampleEntrant()
    {
        return $this->create($this->exampleEntrant);
    }

    /**
     * Create an example committee user.
     *
     * @return User
     */
    public function createExampleCommittee()
    {
        return $this->create($this->exampleCommittee);
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
