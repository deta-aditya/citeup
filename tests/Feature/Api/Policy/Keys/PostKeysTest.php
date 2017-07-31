<?php

namespace Tests\Feature\Api\Policy\Keys;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;

class PostKeysTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt on admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $response = $this->requestToApi(
            $this->randomAdmin(), 'POST', '/keys', $this->randomKeyData()
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
        $response = $this->requestToApi(
            $this->randomCommittee(), 'POST', '/keys', $this->randomKeyData()
        );

        $response->assertStatus(403);
    }

    /**
     * Generate a random user data.
     *
     * @return array
     */
    protected function randomKeyData()
    {
        $faker = resolve('Faker\Generator');

        return [
            'name' => $faker->words(3, true)
        ];
    }
}
