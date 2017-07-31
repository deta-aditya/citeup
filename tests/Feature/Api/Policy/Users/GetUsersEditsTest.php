<?php

namespace Tests\Feature\Api\Policy\Users;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;

class GetUsersEditsTest extends TestCase
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
            $this->randomAdmin(), 'GET', '/users/'. $this->randomCommittee()->id .'/edits'
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

        $this->grant($user, 'get-edits');

        $response = $this->requestToApi(
            $user, 'GET', '/users/'. $this->createFactoryUser(true)->id .'/edits'
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
        $user = $this->randomCommittee();

        $response = $this->requestToApi(
            $user, 'GET', '/users/'. $user->id .'/edits'
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
            $user, 'GET', '/users/'. $other->id .'/edits'
        );

        $response->assertStatus(403);
    }
}
