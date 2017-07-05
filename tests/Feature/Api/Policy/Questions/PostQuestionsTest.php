<?php

namespace Tests\Feature\Api\Policy\Questions;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;

class PostQuestionsTest extends TestCase
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
            $this->randomAdmin(), 'POST', '/questions', $this->randomQuestionData()
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

        $this->grant($user, 'post-questions');

        $response = $this->requestToApi(
            $user, 'POST', '/questions', $this->randomQuestionData()
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
            $user, 'POST', '/questions', $this->randomQuestionData()
        );

        $response->assertStatus(403);
    }    

    /**
     * Generate a random question data.
     *
     * @return array
     */
    protected function randomQuestionData()
    {
        $faker = resolve('Faker\Generator');

        return [
            'content' => $faker->text(),
            'picture' => $faker->text(191),
        ];
    }
}
