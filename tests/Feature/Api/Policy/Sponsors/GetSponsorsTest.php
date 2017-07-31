<?php

namespace Tests\Feature\Api\Policy\Sponsors;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;

class GetSponsorsTest extends TestCase
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
            $this->randomEntrant(), 'GET', '/sponsors'
        );

        $response->assertStatus(200);
    }
}
