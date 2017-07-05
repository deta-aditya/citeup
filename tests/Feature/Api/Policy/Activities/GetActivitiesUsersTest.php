<?php

namespace Tests\Feature\Api\Policy\Activities;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Activity;

class GetActivitiesUsersTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt on admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $activity = $this->createFactoryActivity();

        $response = $this->requestToApi(
            $this->randomAdmin(), 'GET', '/activities/'. $activity->id .'/users'
        );

        $response->assertStatus(200);
    }

    /**
     * Testing a successful keyed attempt.
     *
     * @return void
     */
    public function test200Keyed()
    {
        $user = $this->randomCommittee();

        $activity = $this->createFactoryActivity();

        $this->grant($user, 'get-users');

        $response = $this->requestToApi(
            $user, 'GET', '/activities/'. $activity->id .'/users'
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
        
        $response = $this->requestToApi(
            $this->randomEntrant(), 'GET', '/activities/'. $activity->id .'/users'
        );

        $response->assertStatus(403);
    }

    /**
     * Create a new activity using factory.
     *
     * @return Activity
     */
    protected function createFactoryActivity()
    {
        return factory(Activity::class)->create();
    }
}
