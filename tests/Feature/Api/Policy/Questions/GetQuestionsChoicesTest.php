<?php

namespace Tests\Feature\Api\Policy\Questions;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Question;

class GetQuestionsChoicesTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt by admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $question = $this->createFactoryQuestion();

        $response = $this->requestToApi(
            $this->randomAdmin(), 'GET', '/questions/'. $question->id .'/choices'
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

        $this->grant($user, 'get-choices');

        $response = $this->requestToApi(
            $user, 'GET', '/questions/'. $question->id .'/choices'
        );

        $response->assertStatus(200);
    }

    /**
     * Testing a successful attempt by entrant.
     *
     * @return void
     */
    public function test200Entrant()
    {
        $user = $this->randomEntrant();

        $question = $this->createFactoryQuestion();

        $response = $this->requestToApi(
            $user, 'GET', '/questions/'. $question->id .'/choices'
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
        $user = $this->randomCommittee();

        $question = $this->createFactoryQuestion();

        $response = $this->requestToApi(
            $user, 'GET', '/questions/'. $question->id .'/choices'
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
}
