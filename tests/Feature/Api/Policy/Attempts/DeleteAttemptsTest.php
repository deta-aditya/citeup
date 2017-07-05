<?php

namespace Tests\Feature\Api\Policy\Attempts;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Attempt;

class DeleteAttemptsTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt from admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $user = $this->randomAdmin();

        $attempt = $this->createFactoryAttempt();

        $response = $this->requestToApi(
            $user, 'DELETE', '/attempts/'. $attempt->id
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

        $attempt = $this->createFactoryAttempt();

        $this->grant($user, 'delete-attempts');

        $response = $this->requestToApi(
            $user, 'DELETE', '/attempts/'. $attempt->id
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
        
        $attempt = $this->createFactoryAttempt();

        $response = $this->requestToApi(
            $user, 'DELETE', '/attempts/'. $attempt->id
        );

        $response->assertStatus(403);
    }

    /**
     * Create a new attempt using factory.
     *
     * @return this
     */
    protected function createFactoryAttempt()
    {
        return factory(Attempt::class)->create();
    }
}
