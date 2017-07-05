<?php

namespace Tests\Feature\Api\Policy\Choices;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Choice;

class PutChoicesTest extends TestCase
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

        $choice = $this->createFactoryChoice();

        $response = $this->requestToApi(
            $user, 'PUT', '/choices/'. $choice->id, $this->randomChoiceData()
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

        $choice = $this->createFactoryChoice();

        $this->grant($user, 'put-choices');

        $response = $this->requestToApi(
            $user, 'PUT', '/choices/'. $choice->id, $this->randomChoiceData()
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
        $user = $this->randomEntrant();
        
        $choice = $this->createFactoryChoice();

        $response = $this->requestToApi(
            $user, 'PUT', '/choices/'. $choice->id, $this->randomChoiceData()
        );

        $response->assertStatus(403);
    }

    /**
     * Create a new choice using factory.
     *
     * @return this
     */
    protected function createFactoryChoice()
    {
        return factory(Choice::class)->create();
    }

    /**
     * Generate a random choice data.
     *
     * @param  Entry|null  $entry
     * @return array
     */
    protected function randomChoiceData($entry = null)
    {
        $faker = resolve('Faker\Generator');

        return [
            'content' => $faker->text(),
            'picture' => $faker->text(191),
        ];
    }
}
