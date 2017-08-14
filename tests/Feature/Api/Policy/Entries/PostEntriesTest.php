<?php

namespace Tests\Feature\Api\Policy\Entries;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Activity;
use App\Modules\Models\Entry;
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

        $response = $this->requestToApi(
            $user, 'POST', '/entries', $this->randomEntryData()
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

        $this->grant($user, 'post-entries');

        $response = $this->requestToApi(
            $user, 'POST', '/entries', $this->randomEntryData()
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

        $response = $this->requestToApi(
            $user, 'POST', '/entries', $this->randomEntryData()
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
}
