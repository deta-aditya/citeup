<?php

namespace Tests\Feature\Api\Policy\Sponsors;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Activity;

class PostSponsorsTest extends TestCase
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
            $this->randomAdmin(), 'POST', '/sponsors', $this->randomSponsorData()
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

        $this->grant($user, 'post-sponsors');

        $response = $this->requestToApi(
            $user, 'POST', '/sponsors', $this->randomSponsorData()
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

        $response = $this->requestToApi(
            $user, 'POST', '/sponsors', $this->randomSponsorData()
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
}
