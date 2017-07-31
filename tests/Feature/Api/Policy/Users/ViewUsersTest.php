<?php

namespace Tests\Feature\Api\Policy\Users;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;

class ViewUsersTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt from admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $user = $this->randomEntrant();

        $response = $this->requestToApi(
            $this->randomAdmin(), 'GET', '/users/'. $user->id
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

        $user = $this->randomAdmin();

        $this->grant($accessor, 'view-users');

        $response = $this->requestToApi($accessor, 'GET', '/users/'. $user->id);

        $response->assertStatus(200);
    }

    /**
     * Testing a successful attempt on self.
     *
     * @return void
     */
    public function test200Self()
    {
        $user = $this->randomEntrant();

        $response = $this->requestToApi($user, 'GET', '/users/'. $user->id);

        $response->assertStatus(200);
    }

    /**
     * Testing a forbidden attempt to view admin.
     *
     * @return void
     */
    public function test403ViewAdmin()
    {
        $user = $this->randomCommittee();

        $admin = $this->randomAdmin();

        $response = $this->requestToApi($user, 'GET', '/users/'. $admin->id);

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

        $response = $this->requestToApi($user, 'GET', '/users/'. $other->id);

        $response->assertStatus(403);
    }
}
