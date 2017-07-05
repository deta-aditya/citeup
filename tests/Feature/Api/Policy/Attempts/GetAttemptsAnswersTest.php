<?php

namespace Tests\Feature\Api\Policy\Attempts;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Attempt;
use App\Modules\Models\Activity;
use App\User;

class GetAttemptsAnswersTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt by admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $attempt = $this->createFactoryAttempt();

        $response = $this->requestToApi(
            $this->randomAdmin(), 'GET', '/attempts/'. $attempt->id .'/answers'
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
        $attempt = $this->createFactoryAttempt();

        $user = $this->randomCommittee();

        $this->grant($user, 'get-answers');

        $response = $this->requestToApi(
            $user, 'GET', '/attempts/'. $attempt->id .'/answers'
        );

        $response->assertStatus(200);
    }

    /**
     * Testing a successful attempt by self.
     *
     * @return void
     */
    public function test200Self()
    {
        $user = $this->createFactoryUser();

        $attempt = $this->createFactoryAttempt(
            $this->createFactoryEntryFor($user)
        );

        $response = $this->requestToApi(
            $user, 'GET', '/attempts/'. $attempt->id .'/answers'
        );

        $response->assertStatus(200);
    }

    /**
     * Testing a forbidden attempt on peeking other's answers.
     *
     * @return void
     */
    public function test403Peek()
    {
        $user = $this->createFactoryUser();

        $this->createFactoryEntryFor($user);

        $attempt = $this->createFactoryAttempt(
            $this->createFactoryEntryFor($this->createFactoryUser())
        );

        $response = $this->requestToApi(
            $user, 'GET', '/attempts/'. $attempt->id .'/answers'
        );

        $response->assertStatus(403);
    }

    /**
     * Create a new attempt using factory.
     *
     * @param  Entry|null  $entry
     * @return this
     */
    protected function createFactoryAttempt($entry = null)
    {
        return factory(Attempt::class)->create(
            is_null($entry) ? [] : ['entry_id' => $entry->id]
        );
    }

    /**
     * Create a new entry for the specified user and return it.
     *
     * @param  User  $user
     * @return Entry
     */
    protected function createFactoryEntryFor(User $user)
    {
        $activity = factory(Activity::class)->create();

        resolve('App\Modules\Electrons\Activities\EntryService')->make(
            $user, $activity
        );

        return $user->entry;
    }
}
