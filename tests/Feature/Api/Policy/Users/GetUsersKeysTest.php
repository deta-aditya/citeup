<?php

namespace Tests\Feature\Api\Policy\Users;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;

class GetUsersKeysTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt.
     *
     * @return void
     */
    public function test200()
    {
        $response = $this->requestToApi(
            $this->randomAdmin(), 'GET', '/users/'. $this->randomCommittee()->id .'/keys'
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
            $this->randomEntrant(), 'GET', '/users/'. $this->randomCommittee()->id .'/keys'
        );

        $response->assertStatus(403);
    }
}
