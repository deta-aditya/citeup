<?php

namespace Tests\Feature\Api\Policy\Answers;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Answer;

class DeleteAnswersTest extends TestCase
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

        $answer = $this->createFactoryAnswer();

        $response = $this->requestToApi(
            $user, 'DELETE', '/answers/'. $answer->id
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

        $answer = $this->createFactoryAnswer();

        $this->grant($user, 'delete-answers');

        $response = $this->requestToApi(
            $user, 'DELETE', '/answers/'. $answer->id
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
        
        $answer = $this->createFactoryAnswer();

        $response = $this->requestToApi(
            $user, 'DELETE', '/answers/'. $answer->id
        );

        $response->assertStatus(403);
    }

    /**
     * Create a new answer using factory.
     *
     * @return this
     */
    protected function createFactoryAnswer()
    {
        return factory(Answer::class)->create();
    }
}
