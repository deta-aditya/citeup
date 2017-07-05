<?php

namespace Tests\Feature\Api\Policy\Users;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;

class GetUsersTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt on admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $response = $this->requestToApi($this->randomAdmin(), 'GET', '/users');

        $response->assertStatus(200);
    }

    /**
     * Testing a successful keyed attempt.
     *
     * @return void
     */
    public function test200Keyed()
    {
        $user = $this->randomCommittee();

        $this->grant($user, 'get-users');

        $response = $this->requestToApi($user, 'GET', '/users');

        $response->assertStatus(200);
    }

    /**
     * Testing a forbidden attempt.
     *
     * @return void
     */
    public function test403()
    {
        $response = $this->requestToApi($this->randomEntrant(), 'GET', '/users');

        $response->assertStatus(403);
    }
}
