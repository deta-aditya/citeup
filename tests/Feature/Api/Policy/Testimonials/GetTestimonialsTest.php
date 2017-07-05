<?php

namespace Tests\Feature\Api\Policy\Testimonials;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;

class GetTestimonialsTest extends TestCase
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
            $this->randomEntrant(), 'GET', '/testimonials'
        );

        $response->assertStatus(200);
    }
}
