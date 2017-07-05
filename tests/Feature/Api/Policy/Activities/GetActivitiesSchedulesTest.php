<?php

namespace Tests\Feature\Api\Policy\Activities;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Activity;

class GetActivitiesSchedulesTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt.
     *
     * @return void
     */
    public function test200()
    {
        $activity = $this->createFactoryActivity();

        $response = $this->requestToApi(
            $this->randomEntrant(), 'GET', '/activities/'. $activity->id .'/schedules'
        );

        $response->assertStatus(200);
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
