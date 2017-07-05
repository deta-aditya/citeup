<?php

namespace Tests\Feature\Api\Policy\News;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Activity;
use App\Modules\Models\News;

class PutNewsTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt by admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $news = $this->createFactoryNews();

        $user = $this->randomAdmin();

        $response = $this->requestToApi(
            $user, 'PUT', '/news/'. $news->id, $this->randomNewsData()
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
        $news = $this->createFactoryNews();

        $user = $this->randomCommittee();

        $this->grant($user, 'put-news');

        $response = $this->requestToApi(
            $user, 'PUT', '/news/'. $news->id, $this->randomNewsData()
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
        $news = $this->createFactoryNews();

        $user = $this->randomEntrant();

        $response = $this->requestToApi(
            $user, 'PUT', '/news/'. $news->id, $this->randomNewsData()
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

    /**
     * Create a new news using factory.
     *
     * @return this
     */
    protected function createFactoryNews()
    {
        return factory(News::class)->create();
    }
}
