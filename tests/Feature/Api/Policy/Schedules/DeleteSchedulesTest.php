<?php

namespace Tests\Feature\Api\Policy\Schedules;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Schedule;

class DeleteSchedulesTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt by admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $schedule = $this->createFactorySchedule();

        $user = $this->randomAdmin();

        $response = $this->requestToApi(
            $user, 'DELETE', '/schedules/'. $schedule->id
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
        $schedule = $this->createFactorySchedule();

        $user = $this->randomCommittee();

        $this->grant($user, 'delete-schedules');

        $response = $this->requestToApi(
            $user, 'DELETE', '/schedules/'. $schedule->id
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
        $schedule = $this->createFactorySchedule();

        $user = $this->randomEntrant();

        $response = $this->requestToApi(
            $user, 'DELETE', '/schedules/'. $schedule->id
        );

        $response->assertStatus(403);
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
