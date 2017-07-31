<?php

namespace Tests\Feature\Api\Policy\Users;

use Tests\TestCase;
use App\Modules\Models\Key;
use App\Modules\Testing\TestAssistant;

class PostUsersKeysTest extends TestCase
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
            $this->randomAdmin(), 'POST', '/users/'. $this->randomCommittee()->id .'/keys', $this->randomGrantData()
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
            $this->randomEntrant(), 'POST', '/users/'. $this->randomCommittee()->id .'/keys', $this->randomGrantData()
        );

        $response->assertStatus(403);
    }

    /**
     * Generate a random grant data.
     *
     * @return array
     */
    protected function randomGrantData()
    {
        return [
            'grant' => [
                Key::inRandomOrder()->first()->id
            ]
        ];
    }
}
