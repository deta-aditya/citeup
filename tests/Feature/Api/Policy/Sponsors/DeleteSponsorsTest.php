<?php

namespace Tests\Feature\Api\Policy\Sponsors;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Sponsor;

class DeleteSponsorsTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt by admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $sponsor = $this->createFactorySponsor();

        $user = $this->randomAdmin();

        $response = $this->requestToApi(
            $user, 'DELETE', '/sponsors/'. $sponsor->id
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
        $sponsor = $this->createFactorySponsor();

        $user = $this->randomCommittee();

        $this->grant($user, 'delete-sponsors');

        $response = $this->requestToApi(
            $user, 'DELETE', '/sponsors/'. $sponsor->id
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
        $sponsor = $this->createFactorySponsor();

        $user = $this->randomEntrant();

        $response = $this->requestToApi(
            $user, 'DELETE', '/sponsors/'. $sponsor->id
        );

        $response->assertStatus(403);
    }

    /**
     * Create a new sponsor using factory.
     *
     * @return this
     */
    protected function createFactorySponsor()
    {
        return factory(Sponsor::class)->create();
    }
}
