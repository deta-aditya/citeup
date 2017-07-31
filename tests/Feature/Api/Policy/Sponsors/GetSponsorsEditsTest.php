<?php

namespace Tests\Feature\Api\Policy\Sponsors;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Sponsor;

class GetSponsorsEditsTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt by admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $user = $this->randomAdmin();

        $sponsor = $this->createFactorySponsor();

        $response = $this->requestToApi(
            $user, 'GET', '/sponsors/'. $sponsor->id .'/edits'
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

        $sponsor = $this->createFactorySponsor();

        $this->grant($user, 'get-edits');

        $response = $this->requestToApi(
            $user, 'GET', '/sponsors/'. $sponsor->id .'/edits'
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

        $sponsor = $this->createFactorySponsor();

        $response = $this->requestToApi(
            $user, 'GET', '/sponsors/'. $sponsor->id .'/edits'
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
