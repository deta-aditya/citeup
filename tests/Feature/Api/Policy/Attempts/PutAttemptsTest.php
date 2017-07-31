<?php

namespace Tests\Feature\Api\Policy\Attempts;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Attempt;
use App\Modules\Models\Activity;
use App\User;

class PutAttemptsTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt from admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $user = $this->randomAdmin();

        $attempt = $this->createFactoryAttempt();

        $response = $this->requestToApi(
            $user, 'PUT', '/attempts/'. $attempt->id, $this->randomAttemptData()
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

        $attempt = $this->createFactoryAttempt();

        $this->grant($user, 'put-attempts');

        $response = $this->requestToApi(
            $user, 'PUT', '/attempts/'. $attempt->id, $this->randomAttemptData()
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
        $user = $this->createFactoryUser();
        
        $attempt = $this->createFactoryAttempt();

        $this->createFactoryEntryFor($user);

        $response = $this->requestToApi(
            $user, 'PUT', '/attempts/'. $attempt->id, $this->randomAttemptData()
        );

        $response->assertStatus(403);
    }

    /**
     * Create a new attempt using factory.
     *
     * @return this
     */
    protected function createFactoryAttempt()
    {
        return factory(Attempt::class)->create();
    }

    /**
     * Create a new entry for the specified user and return it.
     *
     * @param  User  $user
     * @return this
     */
    protected function createFactoryEntryFor(User $user)
    {
        $activity = factory(Activity::class)->create();

        resolve('App\Modules\Electrons\Activities\EntryService')->make(
            $user, $activity
        );

        return $user->entry;
    }

    /**
     * Generate a random attempt data.
     *
     * @param  Entry|null  $entry
     * @return array
     */
    protected function randomAttemptData($entry = null)
    {
        $faker = resolve('Faker\Generator');

        return [
            'finished_at' => $faker->date('Y-m-d H:i:s'),
        ];
    }
}
