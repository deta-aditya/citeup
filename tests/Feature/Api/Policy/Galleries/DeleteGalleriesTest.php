<?php

namespace Tests\Feature\Api\Policy\Galleries;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Gallery;

class DeleteGalleriesTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt by admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $gallery = $this->createFactoryGallery();

        $user = $this->randomAdmin();

        $response = $this->requestToApi(
            $user, 'DELETE', '/galleries/'. $gallery->id
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
        $gallery = $this->createFactoryGallery();

        $user = $this->randomCommittee();

        $this->grant($user, 'delete-galleries');

        $response = $this->requestToApi(
            $user, 'DELETE', '/galleries/'. $gallery->id
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
        $gallery = $this->createFactoryGallery();

        $user = $this->randomEntrant();

        $response = $this->requestToApi(
            $user, 'DELETE', '/galleries/'. $gallery->id
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
