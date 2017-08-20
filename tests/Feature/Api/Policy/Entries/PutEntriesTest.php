<?php

namespace Tests\Feature\Api\Policy\Entries;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Activity;
use App\Modules\Models\Entry;
use App\User;

class PutEntriesTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt from admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $entry = $this->createFactoryEntry();

        $user = $this->randomAdmin();

        $response = $this->requestToApi(
            $user, 'PUT', '/entries/' . $entry->id , $this->randomEntryData()
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
        $entry = $this->createFactoryEntry();
        
        $user = $this->randomCommittee();

        $this->grant($user, 'put-entries');

        $response = $this->requestToApi(
            $user, 'PUT', '/entries/' . $entry->id, $this->randomEntryData()
        );

        $response->assertStatus(200);
    }

    /**
     * Testing a successful attempt on self.
     *
     * @return void
     */
    public function test200Self()
    {
        $user = $this->createFactoryUser();

        $entry = $this->createFactoryEntryFor($user);

        $response = $this->requestToApi(
            $user, 'PUT', '/entries/'. $entry->id, $this->randomEntryData()
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
        $entry = $this->createFactoryEntry();

        $user = $this->createFactoryUser();

        $response = $this->requestToApi(
            $user, 'PUT', '/entries/' . $entry->id, $this->randomEntryData()
        );

        $response->assertStatus(403);
    }

    /**
     * Generate a random entry data.
     *
     * @return array
     */
    protected function randomEntryData()
    {
        $faker = resolve('Faker\Generator');

        return [
            'activity' => factory(Activity::class)->create()->id,
            'name' => $faker->name(),
        ];
    }

    /**
     * Create a new entry using factory.
     *
     * @return Entry
     */
    protected function createFactoryEntry()
    {
        return factory(Entry::class)->create();
    }

    /**
     * Create a new entry using factory for specific user.
     *
     * @param  User  $user
     * @return Entry
     */
    protected function createFactoryEntryFor(User $user)
    {
        $entry = $this->createFactoryEntry();

        resolve('App\Modules\Electrons\Activities\EntryService')->associate(
            $user, $entry
        );

        return $entry;
    }
}
