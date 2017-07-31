<?php

namespace Tests\Feature\Api\Policy\Users;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;

class GetUsersAlertsTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt by admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $response = $this->requestToApi(
            $this->randomAdmin(), 'GET', '/users/'. $this->randomEntrant()->id .'/alerts'
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
        $user = $this->randomCommittee();

        $this->grant($user, 'get-alerts');

        $response = $this->requestToApi(
            $user, 'GET', '/users/'. $this->randomEntrant()->id .'/alerts'
        );

        $response->assertStatus(200);
    }

    /**
     * Testing a successful attempt by self.
     *
     * @return void
     */
    public function test200Self()
    {
        $user = $this->randomEntrant();

        $response = $this->requestToApi(
            $user, 'GET', '/users/'. $user->id .'/alerts'
        );

        $response->assertStatus(200);
    }

    /**
     * Testing a forbidden attempt on peeking other's alerts.
     *
     * @return void
     */
    public function test403Peek()
    {
        $user = $this->randomEntrant();

        $other = $this->createFactoryUser();

        $response = $this->requestToApi(
            $user, 'GET', '/users/'. $other->id .'/alerts'
        );

        $response->assertStatus(403);
    }
}
