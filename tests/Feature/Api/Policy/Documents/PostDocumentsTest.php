<?php

namespace Tests\Feature\Api\Policy\Documents;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Activity;
use App\User;

class PostDocumentsTest extends TestCase
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

        $response = $this->requestToApi(
            $user, 'POST', '/documents', $this->randomDocumentData()
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

        $this->grant($user, 'post-documents');

        $response = $this->requestToApi(
            $user, 'POST', '/documents', $this->randomDocumentData()
        );

        $response->assertStatus(200);
    }

    /**
     * Testing a successful attempt by entrant.
     *
     * @return void
     */
    public function test200Entrant()
    {
        $user = $this->createFactoryUser();

        $entry = $this->createFactoryEntryFor($user);

        $response = $this->requestToApi(
            $user, 'POST', '/documents', $this->randomDocumentData($entry)
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

        $response = $this->requestToApi(
            $user, 'POST', '/documents', $this->randomDocumentData()
        );

        $response->assertStatus(403);
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
     * Generate a random document data.
     *
     * @param  Entry|null  $entry
     * @return array
     */
    protected function randomDocumentData($entry = null)
    {
        $faker = resolve('Faker\Generator');

        if (is_null($entry)) {
            $entry = $this->createFactoryEntryFor($this->createFactoryUser());
        }

        return [
            'entry' => $entry->id,
            'file' => $faker->text(191),
            'type' => $faker->numberBetween(0, 9),
        ];
    }
}
