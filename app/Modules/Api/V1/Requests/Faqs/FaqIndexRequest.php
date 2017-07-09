<?php

namespace App\Modules\Api\V1\Requests\Faqs;

use App\Modules\Models\Faq;
use App\Modules\Electrons\Shared\Requests\ApiIndexRequest;

class FaqIndexRequest extends ApiIndexRequest
{
    /**
     * The main model for the request.
     *
     * @var Faq
     */
    protected $model = Faq::class;

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
