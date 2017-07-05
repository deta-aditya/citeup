<?php

namespace Tests\Feature\Api\Policy\Choices;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Choice;

class ViewChoicesTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt by admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $choice = $this->createFactoryChoice();

        $response = $this->requestToApi(
            $this->randomAdmin(), 'GET', '/choices/'. $choice->id
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
     
        $choice = $this->createFactoryChoice();

        $this->grant($user, 'view-choices');

        $response = $this->requestToApi(
            $user, 'GET', '/choices/'. $choice->id
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

        $choice = $this->createFactoryChoice();

        $response = $this->requestToApi(
            $user, 'GET', '/choices/'. $choice->id
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

        $choice = $this->createFactoryChoice();

        $response = $this->requestToApi(
            $user, 'GET', '/choices/'. $choice->id
        );

        $response->assertStatus(403);
    }

    /**
     * Create a new choice using factory.
     *
     * @return this
     */
    protected function createFactoryChoice()
    {
        return factory(Choice::class)->create();
    }
}
