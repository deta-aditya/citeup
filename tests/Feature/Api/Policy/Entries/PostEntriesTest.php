<?php

namespace Tests\Feature\Api\Policy\Entries;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Activity;
use App\User;

class PostEntriesTest extends TestCase
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

        $entry = $this->createFactoryEntryFor($this->createFactoryUser());

        $response = $this->requestToApi(
            $user, 'POST', '/entries/'. $entry->id, $this->randomModifyData()
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

        $entry = $this->createFactoryEntryFor($this->createFactoryUser());

        $this->grant($user, 'post-entries');

        $response = $this->requestToApi(
            $user, 'POST', '/entries/'. $entry->id, $this->randomModifyData()
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

        $entry = $this->createFactoryEntryFor($this->createFactoryUser());

        $response = $this->requestToApi(
            $user, 'POST', '/entries/'. $entry->id, $this->randomModifyData()
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
     * Generate a random modify data.
     *
     * @return array
     */
    protected function randomModifyData()
    {
        $faker = resolve('Faker\Generator');

        return [
            'stage' => $faker->numberBetween(0, 5),
            'status' => $faker->randomElement([0, 1]),
        ];
    }
}
