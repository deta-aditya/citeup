<?php

namespace Tests\Feature\Api\Policy\Activities;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Activity;

class ViewActivitiesTest extends TestCase
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

        $user = $this->randomEntrant();

        $response = $this->requestToApi(
            $user, 'GET', '/activities/'. $activity->id
        );

        $response->assertStatus(200);
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
