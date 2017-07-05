<?php

namespace Tests\Feature\Api\Policy\Questions;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;

class GetQuestionsTest extends TestCase
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
            $this->randomAdmin(), 'GET', '/questions'
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

        $this->grant($user, 'get-questions');

        $response = $this->requestToApi(
            $user, 'GET', '/questions'
        );

        $response->assertStatus(200);
    }

    /**
     * Testing a successful attempt by entrant.
     *
     * @return void
     */
    public function test200Entrant()
    {
        $user = $this->randomEntrant();

        $response = $this->requestToApi(
            $user, 'GET', '/questions'
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
        $user = $this->randomCommittee();

        $response = $this->requestToApi(
            $user, 'GET', '/questions'
        );

        $response->assertStatus(403);
    }
}
