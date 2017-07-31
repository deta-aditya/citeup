<?php

namespace Tests\Feature\Api\Policy\Schedules;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Activity;

class PostSchedulesTest extends TestCase
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
            $this->randomAdmin(), 'POST', '/schedules', $this->randomScheduleData()
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

        $this->grant($user, 'post-schedules');

        $response = $this->requestToApi(
            $user, 'POST', '/schedules', $this->randomScheduleData()
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
            $user, 'POST', '/schedules', $this->randomScheduleData()
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
     * Create a new activity using factory.
     *
     * @return this
     */
    protected function createFactoryActivity()
    {
        return factory(Activity::class)->create();
    }
}
