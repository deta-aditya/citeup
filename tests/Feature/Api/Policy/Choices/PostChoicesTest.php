<?php

namespace Tests\Feature\Api\Policy\Choices;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Question;

class PostChoicesTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt by admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $response = $this->requestToApi(
            $this->randomAdmin(), 'POST', '/choices', $this->randomChoiceData()
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

        $this->grant($user, 'post-choices');

        $response = $this->requestToApi(
            $user, 'POST', '/choices', $this->randomChoiceData()
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

        $response = $this->requestToApi(
            $user, 'POST', '/choices', $this->randomChoiceData()
        );

        $response->assertStatus(403);
    }    

    /**
     * Generate a random choice data.
     *
     * @return array
     */
    protected function randomChoiceData()
    {
        $faker = resolve('Faker\Generator');

        return [
            'question' => factory(Question::class)->create()->id,
            'content' => $faker->text(),
            'picture' => $faker->text(191),
        ];
    }
}
