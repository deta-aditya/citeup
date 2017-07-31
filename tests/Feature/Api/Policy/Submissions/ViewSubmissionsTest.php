<?php

namespace Tests\Feature\Api\Policy\Submissions;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Submission;
use App\Modules\Models\Activity;
use App\User;

class ViewSubmissionsTest extends TestCase
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

        $submission = $this->createFactorySubmission();

        $response = $this->requestToApi(
            $user, 'GET', '/submissions/'. $submission->id
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

        $submission = $this->createFactorySubmission();

        $this->grant($user, 'view-submissions');

        $response = $this->requestToApi(
            $user, 'GET', '/submissions/'. $submission->id
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

        $submission = $this->createFactorySubmission(
            $this->createFactoryEntryFor($user)
        );

        $response = $this->requestToApi(
            $user, 'GET', '/submissions/'. $submission->id
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

        $this->createFactoryEntryFor($user);

        $submission = $this->createFactorySubmission();

        $response = $this->requestToApi(
            $user, 'GET', '/submissions/'. $submission->id
        );

        $response->assertStatus(403);
    }

    /**
     * Create a new submission using factory.
     *
     * @param  Entry|null  $entry
     * @return this
     */
    protected function createFactorySubmission($entry = null)
    {
        return factory(Submission::class)->create(
            is_null($entry) ? [] : ['entry_id' => $entry->id]
        );
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
     * Generate a random submission data.
     *
     * @param  Entry|null  $entry
     * @return array
     */
    protected function randomSubmissionData($entry = null)
    {
        $faker = resolve('Faker\Generator');

        if (is_null($entry)) {
            $entry = $this->createFactoryEntryFor($this->createFactoryUser());
        }

        return [
            'entry_id' => $entry->id,
            'picture' => $faker->text(191),
            'description' => $faker->paragraph,
        ];
    }
}
