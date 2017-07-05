<?php

namespace Tests\Feature\Api\Policy\Documents;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Document;

class DeleteDocumentsTest extends TestCase
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

        $document = $this->createFactoryDocument();

        $response = $this->requestToApi(
            $user, 'DELETE', '/documents/'. $document->id
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

        $document = $this->createFactoryDocument();

        $this->grant($user, 'delete-documents');

        $response = $this->requestToApi(
            $user, 'DELETE', '/documents/'. $document->id
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
        
        $document = $this->createFactoryDocument();

        $response = $this->requestToApi(
            $user, 'DELETE', '/documents/'. $document->id
        );

        $response->assertStatus(403);
    }

    /**
     * Create a new document using factory.
     *
     * @return this
     */
    protected function createFactoryDocument()
    {
        return factory(Document::class)->create();
    }
}
