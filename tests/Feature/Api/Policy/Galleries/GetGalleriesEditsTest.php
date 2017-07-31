<?php

namespace Tests\Feature\Api\Policy\Galleries;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Gallery;

class GetGalleriesEditsTest extends TestCase
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

        $gallery = $this->createFactoryGallery();

        $response = $this->requestToApi(
            $user, 'GET', '/galleries/'. $gallery->id .'/edits'
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

        $gallery = $this->createFactoryGallery();

        $this->grant($user, 'get-edits');

        $response = $this->requestToApi(
            $user, 'GET', '/galleries/'. $gallery->id .'/edits'
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

        $gallery = $this->createFactoryGallery();

        $response = $this->requestToApi(
            $user, 'GET', '/galleries/'. $gallery->id .'/edits'
        );

        $response->assertStatus(403);
    }

    /**
     * Create a new gallery using factory.
     *
     * @return this
     */
    protected function createFactoryGallery()
    {
        return factory(Gallery::class)->create();
    }
}
