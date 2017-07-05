<?php

namespace Tests\Feature\Api\Policy\Activities;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Activity;

class PutActivitiesTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt by admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $activity = $this->createFactoryActivity();

        $user = $this->randomAdmin();

        $response = $this->requestToApi(
            $user, 'PUT', '/activities/'. $activity->id, $this->randomActivityData()
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
        $activity = $this->createFactoryActivity();

        $user = $this->randomCommittee();

        $this->grant($user, 'put-activities');

        $response = $this->requestToApi(
            $user, 'PUT', '/activities/'. $activity->id, $this->randomActivityData()
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
        $activity = $this->createFactoryActivity();

        $user = $this->randomEntrant();

        $response = $this->requestToApi(
            $user, 'PUT', '/activities/'. $activity->id, $this->randomActivityData()
        );

        $response->assertStatus(403);
    }

    /**
     * Create a new activity using factory.
     *
     * @return this
     */
    protected function createFactoryActivity()
    {
        return factory(Activity::class)->create();
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
