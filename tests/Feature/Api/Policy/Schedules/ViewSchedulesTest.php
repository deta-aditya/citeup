<?php

namespace Tests\Feature\Api\Policy\Schedules;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Schedule;

class ViewSchedulesTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt.
     *
     * @return void
     */
    public function test200()
    {
        $schedule = $this->createFactorySchedule();

        $user = $this->randomAdmin();

        $response = $this->requestToApi(
            $user, 'GET', '/schedules/'. $schedule->id
        );

        $response->assertStatus(200);
    }

    /**
     * Create a new schedule using factory.
     *
     * @return this
     */
    protected function createFactorySchedule()
    {
        return factory(Schedule::class)->create();
    }
}
