<?php

namespace Tests\Feature\Api\Policy\Users;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Modules\Electrons\Users\RoleService;
use App\User;

class GetUsersTest extends TestCase
{
    /**
     * Testing a successful attempt.
     *
     * @return void
     */
    public function testSuccessful()
    {
        $response = $this->actingAs(
            User::ofRole(RoleService::ROLE_ADMINISTRATOR)->get()->random(), 'api'
        )->json('GET', '/api/v1/users');

        $response->assertStatus(200);
    }

    /**
     * Testing a successful keyed attempt.
     *
     * @return void
     */
    public function testSuccessfulKeyed()
    {
        $user = User::ofRole(RoleService::ROLE_COMMITTEE)->get()->random();

        $keys = resolve('App\Modules\Electrons\Keys\KeyService');

        $keys->grant($user, $keys->slugsToId(['get-users']));

        $response = $this->actingAs($user, 'api')->json('GET', '/api/v1/users');

        $keys->ungrant($user, $keys->slugsToId(['get-users']));

        $response->assertStatus(200);
    }

    /**
     * Testing a forbidden attempt.
     *
     * @return void
     */
    public function testForbidden()
    {
        $response = $this->actingAs(
            User::ofRole(RoleService::ROLE_ENTRANT)->get()->random(), 'api'
        )->json('GET', '/api/v1/users');

        $response->assertStatus(403);
    }
}
