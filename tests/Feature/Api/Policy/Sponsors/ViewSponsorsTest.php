<?php

namespace Tests\Feature\Api\Policy\Sponsors;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Sponsor;

class ViewSponsorsTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt.
     *
     * @return void
     */
    public function test200()
    {
        $sponsor = $this->createFactorySponsor();

        $user = $this->randomAdmin();

        $response = $this->requestToApi(
            $user, 'GET', '/sponsors/'. $sponsor->id
        );

        $response->assertStatus(200);
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
