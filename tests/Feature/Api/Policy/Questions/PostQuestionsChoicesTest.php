<?php

namespace Tests\Feature\Api\Policy\Questions;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Question;

class PostQuestionsChoicesTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt by admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $user = $this->randomAdmin();

        $question = $this->createFactoryQuestion();

        $response = $this->requestToApi(
            $user, 'POST', '/questions/'. $question->id .'/choices', $this->randomChoiceData()
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
     
        $question = $this->createFactoryQuestion();

        $this->grant($user, 'post-questions-choices');

        $response = $this->requestToApi(
            $user, 'POST', '/questions/'. $question->id .'/choices', $this->randomChoiceData()
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

        $question = $this->createFactoryQuestion();

        $response = $this->requestToApi(
            $user, 'POST', '/questions/'. $question->id .'/choices', $this->randomChoiceData()
        );

        $response->assertStatus(403);
    }

    /**
     * Create a new question using factory.
     *
     * @return this
     */
    protected function createFactoryQuestion()
    {
        return factory(Question::class)->create();
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
            'choices' => [
                [
                    'content' => $faker->text(),
                    'picture' => $faker->text(191),
                ]
            ],
        ];
    }
}
