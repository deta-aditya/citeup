<?php

namespace App\Modules\Testing;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Modules\Electrons\Users\RoleService;
use App\Modules\Models\Activity;
use App\Modules\Models\Entry;
use App\User;

trait TestAssistant
{
    use DatabaseTransactions;

    /**
     * Retrieve a random user from the database.
     * 
     * @param  int  $role
     * @return User
     */
    protected function getRandomUser($role)
    {
        return User::ofRole($role)->get()->random();
    }

    /**
     * Grant the user a given key.
     *
     * @param  User   $user
     * @param  string  $key
     * @return this
     */
    protected function grant(User $user, $key)
    {
        $keys = resolve('App\Modules\Electrons\Keys\KeyService');

        $keys->grant($user, $keys->slugsToId([$key]));

        return $this;
    }

    /**
     * Fake request to the API.
     *
     * @param  User    $user
     * @param  string  $method
     * @param  string  $resource
     * @param  mixed   $param
     * @return Response
     */
    protected function requestToApi(User $user, $method, $resource, $param = [])
    {
        return $this->actingAs($user, 'api')->json($method, '/api/v1'. $resource, $param);
    }

    /**
     * Retrieve a random administrator user.
     *
     * @return User
     */
    protected function randomAdmin()
    {
        return $this->getRandomUser(RoleService::ROLE_ADMINISTRATOR);
    }

    /**
     * Retrieve a random committee user.
     *
     * @return User
     */
    protected function randomCommittee()
    {
        return $this->getRandomUser(RoleService::ROLE_COMMITTEE);
    }

    /**
     * Retrieve a random entrant user.
     *
     * @return User
     */
    protected function randomEntrant()
    {
        return $this->getRandomUser(RoleService::ROLE_ENTRANT);
    }

    /**
     * Generate a random user data.
     *
     * @param  int  $role
     * @return array
     */
    protected function randomUserData($role = RoleService::ROLE_ENTRANT)
    {
        $faker = resolve('Faker\Generator');

        $password = bcrypt('rahasia');

        $userData = [
            'email' => $faker->unique()->safeEmail,
            'password' => $password,
            'password_confirmation' => $password,
            'role' => $role,
            'name' => $faker->name,
        ];

        switch ($role) {
            case RoleService::ROLE_ENTRANT: 
                $userData['entry'] = factory(Entry::class)->create()->id;
                break;
            case RoleService::ROLE_COMMITTEE:
                $userData['section'] = $faker->word;
                break;
        }

        return $userData;
    }

    /**
     * Create a new user using factory.
     *
     * @param  bool  $committee
     * @return User
     */
    protected function createFactoryUser($committee = false)
    {
        $user = $committee ? 
            factory(User::class)->create(
                ['role_id' => RoleService::ROLE_COMMITTEE]
            ) :
            factory(User::class)->create();

        return $user;
    }
}