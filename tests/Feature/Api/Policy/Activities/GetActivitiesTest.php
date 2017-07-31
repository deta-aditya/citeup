<?php

namespace Tests\Feature\Api\Policy\Activities;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;

class GetActivitiesTest extends TestCase
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
            $this->randomEntrant(), 'GET', '/activities'
        );

        $response->assertStatus(200);
    }
}
