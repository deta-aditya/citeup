<?php

namespace Tests\Feature\Api\Policy\Sponsors;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Activity;
use App\Modules\Models\Sponsor;

class PutSponsorsTest extends TestCase
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
            $user, 'PUT', '/sponsors/'. $sponsor->id, $this->randomSponsorData()
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

        $this->grant($user, 'put-sponsors');

        $response = $this->requestToApi(
            $user, 'PUT', '/sponsors/'. $sponsor->id, $this->randomSponsorData()
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
            $user, 'PUT', '/sponsors/'. $sponsor->id, $this->randomSponsorData()
        );

        $response->assertStatus(403);
    }    

    /**
     * Generate a random sponsor data.
     *
     * @return array
     */
    protected function randomSponsorData()
    {
        $faker = resolve('Faker\Generator');

        return [
            'name' => $faker->text(191),
            'picture' => $faker->text(191),
        ];
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
