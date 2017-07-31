<?php

namespace Tests\Feature\Api\Policy\Galleries;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Activity;

class PostGalleriesTest extends TestCase
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
            $this->randomAdmin(), 'POST', '/galleries', $this->randomGalleryData()
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

        $this->grant($user, 'post-galleries');

        $response = $this->requestToApi(
            $user, 'POST', '/galleries', $this->randomGalleryData()
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
            $user, 'POST', '/galleries', $this->randomGalleryData()
        );

        $response->assertStatus(403);
    }    

    /**
     * Generate a random gallery data.
     *
     * @return array
     */
    protected function randomGalleryData()
    {
        $faker = resolve('Faker\Generator');

        return [
            'picture' => $faker->text(191),
            'caption' => $faker->text(191),
        ];
    }
}
