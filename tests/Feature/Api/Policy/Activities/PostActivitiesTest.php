<?php

namespace Tests\Feature\Api\Policy\Activities;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;

class PostActivitiesTest extends TestCase
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
            $this->randomAdmin(), 'POST', '/activities', $this->randomActivityData()
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

        $this->grant($user, 'post-activities');

        $response = $this->requestToApi(
            $user, 'POST', '/activities', $this->randomActivityData()
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
            $user, 'POST', '/activities', $this->randomActivityData()
        );

        $response->assertStatus(403);
    }    

    /**
     * Generate a random activity data.
     *
     * @return array
     */
    protected function randomActivityData()
    {
        $faker = resolve('Faker\Generator');

        return [
            'name' => $faker->words(2, true),
        ];
    }
}
