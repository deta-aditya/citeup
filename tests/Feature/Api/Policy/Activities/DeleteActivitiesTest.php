<?php

namespace Tests\Feature\Api\Policy\Activities;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Activity;

class DeleteActivitiesTest extends TestCase
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
            $user, 'DELETE', '/activities/'. $activity->id
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

        $this->grant($user, 'delete-activities');

        $response = $this->requestToApi(
            $user, 'DELETE', '/activities/'. $activity->id
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
            $user, 'DELETE', '/activities/'. $activity->id
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
}
