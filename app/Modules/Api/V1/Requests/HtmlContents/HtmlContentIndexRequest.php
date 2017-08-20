<?php

namespace App\Modules\Api\V1\Requests\HtmlContents;

use App\Modules\Models\HtmlContent;
use App\Modules\Electrons\Shared\Requests\ApiIndexRequest;

class HtmlContentIndexRequest extends ApiIndexRequest
{
    /**
     * The main model for the request.
     *
     * @var HtmlContent
     */
    protected $model = HtmlContent::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
