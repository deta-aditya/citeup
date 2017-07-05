<?php

namespace Tests\Feature\Api\Policy\Documents;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Document;
use App\Modules\Models\Activity;
use App\User;

class PutDocumentsTest extends TestCase
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

        $document = $this->createFactoryDocument();

        $response = $this->requestToApi(
            $user, 'PUT', '/documents/'. $document->id, $this->randomDocumentData()
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

        $document = $this->createFactoryDocument();

        $this->grant($user, 'put-documents');

        $response = $this->requestToApi(
            $user, 'PUT', '/documents/'. $document->id, $this->randomDocumentData()
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

        $document = $this->createFactoryDocument($entry);

        $response = $this->requestToApi(
            $user, 'PUT', '/documents/'. $document->id, $this->randomDocumentData()
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

        $document = $this->createFactoryDocument();

        $this->createFactoryEntryFor($user);

        $response = $this->requestToApi(
            $user, 'PUT', '/documents/'. $document->id, $this->randomDocumentData()
        );

        $response->assertStatus(403);
    }

    /**
     * Create a new document using factory.
     *
     * @param  Entry|null  $entry
     * @return this
     */
    protected function createFactoryDocument($entry = null)
    {
        return factory(Document::class)->create(
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
     * Generate a random document data.
     *
     * @return array
     */
    protected function randomDocumentData()
    {
        $faker = resolve('Faker\Generator');

        return [
            'file' => $faker->text(191),
            'type' => $faker->numberBetween(0, 9),
        ];
    }
}
