<?php

namespace Tests\Feature\Api\Policy\News;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;

class GetNewsTest extends TestCase
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
            $this->randomEntrant(), 'GET', '/news'
        );

        $response->assertStatus(200);
    }
}
