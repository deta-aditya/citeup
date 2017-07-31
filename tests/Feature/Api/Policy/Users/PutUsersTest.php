<?php

namespace Tests\Feature\Api\Policy\Users;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;

class PutUsersTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt from admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $user = $this->createFactoryUser();

        $response = $this->requestToApi(
            $this->randomAdmin(), 'PUT', '/users/'. $user->id, $this->randomUserData()
        );

        $response->assertStatus(200);
    }

    /**
     * Testing a successful attempt using key.
     *
     * @return void
     */
    public function test200Keyed()
    {
        $accessor = $this->randomCommittee();

        $user = $this->createFactoryUser();

        $this->grant($accessor, 'put-users');

        $response = $this->requestToApi(
            $accessor, 'PUT', '/users/'. $user->id, $this->randomUserData()
        );

        $response->assertStatus(200);
    }

    /**
     * Testing a successful attempt on self.
     *
     * @return void
     */
    public function test200Self()
    {
        $user = $this->createFactoryUser();

        $response = $this->requestToApi(
            $user, 'PUT', '/users/'. $user->id, $this->randomUserData()
        );

        $response->assertStatus(200);
    }

    /**
     * Testing a forbidden attempt.
     *
     * @return void
     */
    public function test403()
    {
        $user = $this->randomEntrant();

        $other = $this->randomCommittee();

        $response = $this->requestToApi(
            $user, 'PUT', '/users/'. $other->id, $this->randomUserData()
        );

        $response->assertStatus(403);
    }

    /**
     * Generate a random user data.
     *
     * @param  null  $role
     * @return array
     */
    protected function randomUserData($role = null)
    {
        return [
            'name' => str_random(10),
        ];
    }
}
