<?php

namespace App\Modules\Api\V1\Requests\Galleries;

use App\Modules\Models\Gallery;
use App\Modules\Electrons\Shared\Requests\ApiIndexRequest;

class GalleryIndexRequest extends ApiIndexRequest
{
    /**
     * The main model for the request.
     *
     * @var Gallery
     */
    protected $model = Gallery::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('get', Gallery::class);
    }
}
