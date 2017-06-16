<?php

namespace App\Modules\Api\V1\Controllers;

use App\Modules\Models\Gallery;
use App\Modules\Electrons\Galleries\GalleryService;
use App\Modules\Api\V1\Requests\Galleries\GalleryIndexRequest;
use App\Modules\Api\V1\Requests\Galleries\GalleryInsertRequest;
use App\Modules\Api\V1\Requests\Galleries\GalleryUpdateRequest;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    use JsonApiController;

    /**
     * A gallery service instance.
     *
     * @var GalleryService
     */
    protected $galleries;

    /**
     * Create a new controller instance.
     *
     * @param  GalleryService  $galleries
     * @return void
     */
    public function __construct(GalleryService $galleries)
    {
        $this->galleries = $galleries;
    }

    /**
     * Get an array of galleries data.
     *
     * @param  GalleryIndexRequest  $request
     * @return Response
     */
    public function index(GalleryIndexRequest $request)
    {
        return $this->respondJson(
            ['galleries' => $this->galleries->getMultiple($request->all())]
        );
    }

    /**
     * Get a gallery data.
     *
     * @param  Request   $request
     * @param  Gallery  $gallery
     * @return Response
     */
    public function show(Request $request, Gallery $gallery)
    {
        return $this->respondJson(['gallery' => $gallery]);   
    }

    /**
     * Insert a new gallery data.
     *
     * @param  GalleryInsertRequest  $request
     * @return Response
     */
    public function insert(GalleryInsertRequest $request)
    {
        $gallery = $this->galleries->create($request->all());

        return $this->respondJson(['gallery' => $gallery]);
    }

    /**
     * Update a gallery data.
     *
     * @param  GalleryUpdateRequest  $request
     * @param  Gallery               $gallery
     * @return Response
     */
    public function update(GalleryUpdateRequest $request, Gallery $gallery)
    {
        $this->galleries->update($gallery, $request->all());

        return $this->respondJson(['gallery' => $gallery]);
    }

    /**
     * Delete a gallery data.
     *
     * @param  Request   $request
     * @param  Gallery  $gallery
     * @return Response
     */
    public function remove(Request $request, Gallery $gallery)
    {
        $this->galleries->remove($gallery);

        return $this->respondJson(['gallery' => $gallery]);
    }
}
