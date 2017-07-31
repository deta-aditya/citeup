<?php

namespace Tests\Feature\Api\Policy\News;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;

class PostNewsTest extends TestCase
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
            $this->randomAdmin(), 'POST', '/news', $this->randomNewsData()
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

        $this->grant($user, 'post-news');

        $response = $this->requestToApi(
            $user, 'POST', '/news', $this->randomNewsData()
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
            $user, 'POST', '/news', $this->randomNewsData()
        );

        $response->assertStatus(403);
    }    

    /**
     * Generate a random news data.
     *
     * @return array
     */
    protected function randomNewsData()
    {
        $faker = resolve('Faker\Generator');

        return [
            'title' => $faker->text(191),
            'picture' => $faker->text(191),
            'content' => $faker->paragraphs(5, true),
        ];
    }
}
