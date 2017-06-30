<?php

namespace App\Modules\Api\V1\Requests\News;

use App\Modules\Models\News;
use App\Modules\Electrons\Shared\Requests\ApiIndexRequest;

class NewsIndexRequest extends ApiIndexRequest
{
    /**
     * The main model for the request.
     *
     * @var News
     */
    protected $model = News::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('get', News::class);
    }
}
