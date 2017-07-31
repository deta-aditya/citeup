<?php

namespace Tests\Feature\Api\Policy\Keys;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Key;

class PutKeysTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt on admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $key = $this->createFactoryKey();
        
        $response = $this->requestToApi(
            $this->randomAdmin(), 'PUT', '/keys/'. $key->id, $this->randomKeyData()
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
        $key = $this->createFactoryKey();

        $response = $this->requestToApi(
            $this->randomCommittee(), 'PUT', '/keys/'. $key->id, $this->randomKeyData()
        );

        $response->assertStatus(403);
    }

    /**
     * Generate a random key data.
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

    /**
     * Create a new key using factory.
     *
     * @return Key
     */
    protected function createFactoryKey()
    {
        return factory(Key::class)->create();
    }
}
