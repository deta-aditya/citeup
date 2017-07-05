<?php

namespace Tests\Feature\Api\Policy\Schedules;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Activity;
use App\Modules\Models\Schedule;

class PutSchedulesTest extends TestCase
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
            $user, 'PUT', '/schedules/'. $schedule->id, $this->randomScheduleData()
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

        $this->grant($user, 'put-schedules');

        $response = $this->requestToApi(
            $user, 'PUT', '/schedules/'. $schedule->id, $this->randomScheduleData()
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
            $user, 'PUT', '/schedules/'. $schedule->id, $this->randomScheduleData()
        );

        $response->assertStatus(403);
    }    

    /**
     * Generate a random schedule data.
     *
     * @return array
     */
    protected function randomScheduleData()
    {
        $faker = resolve('Faker\Generator');

        return [
            'activity' => $this->createFactoryActivity()->id,
            'description' => $faker->text(191),
            'held_at' => $faker->date('Y-m-d H:i:s')
        ];
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
