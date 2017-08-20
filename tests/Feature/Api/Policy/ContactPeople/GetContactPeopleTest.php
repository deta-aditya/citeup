<?php

namespace Tests\Feature\Api\Policy\ContactPeople;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;

class GetContactPeopleTest extends TestCase
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
            $this->randomEntrant(), 'GET', '/contact-people'
        );

        $response->assertStatus(200);
    }
}
