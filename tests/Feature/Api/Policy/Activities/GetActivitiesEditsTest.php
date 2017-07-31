<?php

namespace Tests\Feature\Api\Policy\Activities;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Activity;

class GetActivitiesEditsTest extends TestCase
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

        $activity = $this->createFactoryActivity();

        $response = $this->requestToApi(
            $user, 'GET', '/activities/'. $activity->id .'/edits'
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

        $activity = $this->createFactoryActivity();

        $this->grant($user, 'get-edits');

        $response = $this->requestToApi(
            $user, 'GET', '/activities/'. $activity->id .'/edits'
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

        $activity = $this->createFactoryActivity();

        $response = $this->requestToApi(
            $user, 'GET', '/activities/'. $activity->id .'/edits'
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
