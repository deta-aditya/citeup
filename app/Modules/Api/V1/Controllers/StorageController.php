<?php

namespace App\Modules\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Electrons\Storage\StorageService;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use App\Modules\Api\V1\Requests\Storage\StorageInsertRequest;
use App\Modules\Api\V1\Requests\Storage\StorageDeleteRequest;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    use JsonApiController;

    /**
     * A storage service instance.
     *
     * @var StorageService
     */
    protected $storages;

    /**
     * Create a new controller instance.
     *
     * @param  StorageService  $storages
     * @return void
     */
    public function __construct(StorageService $storages)
    {
        $this->storages = $storages;
    }
    
    /**
     * Inserts a new file into the storage
     *
     * @param  StorageInsertRequest  $request
     * @return Response
     */
    public function insert(StorageInsertRequest $request)
    {
        return $this->respondJson(
            ['link' => $this->storages->upload($request->all())]
        );
    }
    
    /**
     * Delete a file from the storage
     *
     * @param  StorageDeleteRequest  $request
     * @return Response
     */
    public function delete(StorageDeleteRequest $request)
    {
        $this->storages->remove($request->input('link'));

        return $this->respondJson([]);
    }

}
