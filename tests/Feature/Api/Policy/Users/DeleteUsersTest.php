<?php

namespace Tests\Feature\Api\Policy\Users;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;

class DeleteUsersTest extends TestCase
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
            $this->randomAdmin(), 'DELETE', '/users/'. $user->id
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

        $this->grant($accessor, 'delete-users');

        $response = $this->requestToApi(
            $accessor, 'DELETE', '/users/'. $user->id
        );

        $response->assertStatus(200);
    }

    /**
     * Testing a forbidden attempt on self.
     *
     * @return void
     */
    public function test403Self()
    {
        $user = $this->randomAdmin();

        $response = $this->requestToApi($user, 'DELETE', '/users/'. $user->id);

        $response->assertStatus(403);
    }

    /**
     * Testing a forbidden attempt by unauthorized user.
     *
     * @return void
     */
    public function test403Unauth()
    {
        $user = $this->randomEntrant();

        $other = $this->randomCommittee();

        $response = $this->requestToApi($user, 'DELETE', '/users/'. $other->id);

        $response->assertStatus(403);
    }
}
