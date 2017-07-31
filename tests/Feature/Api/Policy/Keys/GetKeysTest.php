<?php

namespace Tests\Feature\Api\Policy\Keys;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;

class GetKeysTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt on admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $response = $this->requestToApi($this->randomAdmin(), 'GET', '/keys');

        $response->assertStatus(200);
    }

    /**
     * Testing a forbidden attempt.
     *
     * @return void
     */
    public function test403()
    {
        $response = $this->requestToApi($this->randomCommittee(), 'GET', '/keys');

        $response->assertStatus(403);
    }
}
