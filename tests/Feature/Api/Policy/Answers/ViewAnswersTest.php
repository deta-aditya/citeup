<?php

namespace Tests\Feature\Api\Policy\Answers;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Answer;
use App\Modules\Models\Attempt;
use App\Modules\Models\Activity;
use App\User;

class ViewAnswersTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt by admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $answer = $this->createFactoryAnswer();

        $response = $this->requestToApi(
            $this->randomAdmin(), 'GET', '/answers/'. $answer->id
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
        
        $answer = $this->createFactoryAnswer();

        $this->grant($user, 'view-answers');

        $response = $this->requestToApi(
            $user, 'GET', '/answers/'. $answer->id
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
        
        $answer = $this->createFactoryAnswer($attempt);

        $response = $this->requestToApi(
            $user, 'GET', '/answers/'. $answer->id
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

        $answer = $this->createFactoryAnswer();

        $this->createFactoryEntryFor($user);

        $response = $this->requestToApi(
            $user, 'GET', '/answers/'. $answer->id
        );

        $response->assertStatus(403);
    }

    /**
     * Generate an answer data.
     *
     * @param  Attempt|null  $attempt
     * @return array
     */
    protected function createFactoryAnswer($attempt = null)
    {
        return factory(Answer::class)->create(
            is_null($attempt) ? [] : ['attempt_id' => $attempt->id]
        );
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
