<?php

namespace Tests\Feature\Api\Policy\Submissions;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Submission;

class DeleteSubmissionsTest extends TestCase
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

        $submission = $this->createFactorySubmission();

        $response = $this->requestToApi(
            $user, 'DELETE', '/submissions/'. $submission->id
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

        $submission = $this->createFactorySubmission();

        $this->grant($user, 'delete-submissions');

        $response = $this->requestToApi(
            $user, 'DELETE', '/submissions/'. $submission->id
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
        
        $submission = $this->createFactorySubmission();

        $response = $this->requestToApi(
            $user, 'DELETE', '/submissions/'. $submission->id
        );

        $response->assertStatus(403);
    }

    /**
     * Create a new submission using factory.
     *
     * @return this
     */
    protected function createFactorySubmission()
    {
        return factory(Submission::class)->create();
    }
}
