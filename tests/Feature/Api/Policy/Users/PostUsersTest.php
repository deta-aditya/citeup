<?php

namespace Tests\Feature\Api\Policy\Users;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;

class PostUsersTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt from admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $response = $this->requestToApi(
            $this->randomAdmin(), 'POST', '/users', $this->randomUserData()
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

        $this->grant($user, 'post-users');

        $response = $this->requestToApi(
            $user, 'POST', '/users', $this->randomUserData()
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
        $response = $this->requestToApi(
            $this->randomEntrant(), 'POST', '/users', $this->randomUserData()
        );

        $response->assertStatus(403);
    }
}
