<?php

namespace Tests\Feature\Api\Policy\ContactPeople;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;

class PostContactPeopleTest extends TestCase
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
            $this->randomAdmin(), 'POST', '/contact-people', $this->randomContactPersonData()
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

        $this->grant($user, 'post-contact-people');

        $response = $this->requestToApi(
            $user, 'POST', '/contact-people', $this->randomContactPersonData()
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
            $user, 'POST', '/contact-people', $this->randomContactPersonData()
        );

        $response->assertStatus(403);
    }    

    /**
     * Generate a random contact data.
     *
     * @return array
     */
    protected function randomContactPersonData()
    {
        $faker = resolve('Faker\Generator');

        return [
            'name' => $faker->text(191),
            'email' => $faker->safeEmail,
        ];
    }
}
