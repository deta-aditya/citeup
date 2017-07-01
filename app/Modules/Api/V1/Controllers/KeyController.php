<?php

namespace App\Modules\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Models\Key;
use App\Modules\Electrons\Keys\KeyService;
use App\Modules\Electrons\Users\UserService;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use App\Modules\Api\V1\Requests\Users\UserIndexRequest;
use App\Modules\Api\V1\Requests\Keys\KeyIndexRequest;
use App\Modules\Api\V1\Requests\Keys\KeyShowRequest;
use App\Modules\Api\V1\Requests\Keys\KeyInsertRequest;
use App\Modules\Api\V1\Requests\Keys\KeyUpdateRequest;
use App\Modules\Api\V1\Requests\Keys\KeyDeleteRequest;
use App\Modules\Api\V1\Requests\Keys\RegisterUserRequest;
use Illuminate\Http\Request;

class KeyController extends Controller
{
    use JsonApiController;

    /**
     * A key service instance.
     *
     * @var KeyService
     */
    protected $keys;

    /**
     * Create a new controller instance.
     *
     * @param  KeyService  $keys
     * @return void
     */
    public function __construct(KeyService $keys)
    {
        $this->keys = $keys;
    }

    /**
     * Get an array of keys data.
     *
     * @param  KeyIndexRequest  $request
     * @return Response
     */
    public function index(KeyIndexRequest $request)
    {
        return $this->respondJson(
            ['keys' => $this->keys->getMultiple($request->all())]
        );
    }

    /**
     * Get a key data.
     *
     * @param  KeyShowRequest  $request
     * @param  Key      $key
     * @return Response
     */
    public function show(KeyShowRequest $request, Key $key)
    {
        $this->authorize('view', $key);

        return $this->respondJson(['key' => $key]);   
    }

    /**
     * Insert a new key data.
     *
     * @param  KeyInsertRequest  $request
     * @return Response
     */
    public function insert(KeyInsertRequest $request)
    {
        $key = $this->keys->create($request->all());

        return $this->respondJson(['key' => $key]);
    }

    /**
     * Update a key data.
     *
     * @param  KeyUpdateRequest  $request
     * @param  Key               $key
     * @return Response
     */
    public function update(KeyUpdateRequest $request, Key $key)
    {
        $this->keys->update($key, $request->all());

        return $this->respondJson(['key' => $key]);
    }

    /**
     * Delete a key data.
     *
     * @param  KeyDeleteRequest  $request
     * @param  Key      $key
     * @return Response
     */
    public function remove(KeyDeleteRequest $request, Key $key)
    {
        $this->authorize('delete', $key);

        $this->keys->remove($key);

        return $this->respondJson(['key' => $key]);
    }

    /**
     * Get users owning the given key.
     *
     * @param  UserIndexRequest  $request
     * @param  Key               $key
     * @param  UserService       $users
     * @return Response 
     */
    public function users(UserIndexRequest $request, Key $key, UserService $users)
    {
        $queries = $request->all();

        $queries['keys'] = $key->id;

        return $this->respondJson(
            ['users' => $users->getMultiple($queries)]
        );
    }

    /**
     * Register or unregister users for having the given key.
     *
     * @param  RegisterUserRequest  $request
     * @param  Key                  $key
     * @param  UserService          $users
     * @return Response
     */
    public function registerUsers(RegisterUserRequest $request, Key $key, UserService $users)
    {
        $this->keys
            ->grantMultiple($request->input('register', []), [$key->id])
            ->ungrantMultiple($request->input('unregister', []), [$key->id]);

        return $this->respondJson(
            ['users' => $users->getMultiple(['keys' => $key->id])]
        );
    }
}
