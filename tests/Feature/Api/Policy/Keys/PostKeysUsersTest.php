<?php

namespace Tests\Feature\Api\Policy\Keys;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Key;

class PostKeysUsersTest extends TestCase
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
            $this->randomAdmin(), 'POST', '/keys/'. $key->id .'/users', $this->randomRegisterData()
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
            $this->randomCommittee(), 'POST', '/keys/'. $key->id .'/users', $this->randomRegisterData()
        );

        $response->assertStatus(403);
    }

    /**
     * Generate a random register data.
     *
     * @return array
     */
    protected function randomRegisterData()
    {   
        return [
            'register' => [
                $this->createFactoryUser()->id
            ],
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
