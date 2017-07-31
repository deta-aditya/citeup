<?php

namespace Tests\Feature\Api\Policy\Answers;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Attempt;
use App\Modules\Models\Activity;
use App\User;

class GetAnswersTest extends TestCase
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
            $this->randomAdmin(), 'GET', '/answers', $this->randomAnswerData()
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

        $this->grant($user, 'get-answers');

        $response = $this->requestToApi(
            $user, 'GET', '/answers', $this->randomAnswerData()
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
            $user, 'GET', '/answers', $this->randomAnswerData($attempt)
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

        $attempt = $this->createFactoryAttempt(
            $this->createFactoryEntryFor($this->createFactoryUser())
        );

        $this->createFactoryEntryFor($user);

        $response = $this->requestToApi(
            $user, 'GET', '/answers', $this->randomAnswerData($attempt)
        );

        $response->assertStatus(403);
    }

    /**
     * Generate an answer data.
     *
     * @param  Attempt|null  $attempt
     * @return array
     */
    protected function randomAnswerData($attempt = null)
    {
        if (is_null($attempt)) {
            $attempt = $this->createFactoryAttempt(
                $this->createFactoryEntryFor($this->createFactoryUser())
            );
        }

        return [
            'attempt' => $attempt->id,
        ];
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
