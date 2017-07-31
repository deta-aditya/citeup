<?php

namespace Tests\Feature\Api\Policy\Galleries;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Gallery;

class ViewGalleriesTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt.
     *
     * @return void
     */
    public function test200()
    {
        $gallery = $this->createFactoryGallery();

        $user = $this->randomAdmin();

        $response = $this->requestToApi(
            $user, 'GET', '/galleries/'. $gallery->id
        );

        $response->assertStatus(200);
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
